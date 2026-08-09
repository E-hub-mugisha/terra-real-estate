<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PropertyRequestsExport;

class PropertyRequestController extends Controller
{
    /**
     * Province => districts, used to populate the cascading location
     * select on the create form. Adjust/replace with your existing
     * Terra province/district source if you already have one (e.g.
     * the same dataset used on the agent-management cascading dropdowns).
     */
    protected array $provinceDistricts = [
        'Kigali City' => ['Gasabo', 'Kicukiro', 'Nyarugenge'],
        'Northern Province' => ['Musanze', 'Gicumbi', 'Rulindo', 'Burera', 'Gakenke'],
        'Southern Province' => ['Huye', 'Nyanza', 'Muhanga', 'Kamonyi', 'Ruhango', 'Nyamagabe', 'Gisagara'],
        'Eastern Province' => ['Rwamagana', 'Nyagatare', 'Kayonza', 'Kirehe', 'Ngoma', 'Bugesera', 'Gatsibo'],
        'Western Province' => ['Rubavu', 'Rusizi', 'Karongi', 'Nyabihu', 'Ngororero', 'Rutsiro', 'Nyamasheke'],
    ];

    public function index(Request $request)
    {
        $query = PropertyRequest::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('request_type')) {
            $query->where('request_type', $request->request_type);
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('is_public')) {
            $query->where('is_public', $request->is_public === '1');
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($sub) use ($search) {
                $sub->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        $requests = $query->paginate(20)->withQueryString();

        $counts = [
            'all' => PropertyRequest::count(),
            'new' => PropertyRequest::where('status', 'new')->count(),
            'in_review' => PropertyRequest::where('status', 'in_review')->count(),
            'matched' => PropertyRequest::where('status', 'matched')->count(),
            'closed' => PropertyRequest::where('status', 'closed')->count(),
            'unmatched' => PropertyRequest::where('status', 'unmatched')->count(),
        ];

        return view('admin.property-requests.index', [
            'requests' => $requests,
            'counts' => $counts,
        ]);
    }

    public function create()
    {
        return view('admin.property-requests.create', [
            'provinceDistricts' => $this->provinceDistricts,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $propertyRequest = PropertyRequest::create($validated);

        return redirect()
            ->route('admin.property-requests.show', $propertyRequest)
            ->with('success', "Request {$propertyRequest->reference_number} created.");
    }

    public function show(string $id)
    {
        $propertyRequest = PropertyRequest::findOrFail($id);

        return view('admin.property-requests.show', compact('propertyRequest'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $propertyRequest = PropertyRequest::findOrFail($id);

        $validated = $request->validate([
            'status'         => ['required', Rule::in(array_keys(PropertyRequest::STATUSES))],
            'assigned_agent' => ['nullable', 'string', 'max:255'],
            'admin_notes'    => ['nullable', 'string'],
            'is_public'      => ['nullable', 'boolean'],
        ]);

        $wasReviewed = $propertyRequest->reviewed_at !== null;

        $propertyRequest->update([
            'status'         => $validated['status'],
            'assigned_agent' => $validated['assigned_agent'] ?? $propertyRequest->assigned_agent,
            'admin_notes'    => $validated['admin_notes'] ?? $propertyRequest->admin_notes,
            'is_public'      => $request->boolean('is_public'),
            'reviewed_at'    => $wasReviewed ? $propertyRequest->reviewed_at : now(),
        ]);

        return back()->with('success', 'Request updated.');
    }

    public function destroy(string $id)
    {
        $propertyRequest = PropertyRequest::findOrFail($id);
        $propertyRequest->delete();

        return redirect()
            ->route('admin.property-requests.index')
            ->with('success', "Request {$propertyRequest->reference_number} deleted.");
    }

    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^07[2-9]\d{7}$/'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'preferred_contact' => ['required', Rule::in(array_keys(PropertyRequest::CONTACT_METHODS))],

            'request_type' => ['required', Rule::in(array_keys(PropertyRequest::REQUEST_TYPES))],
            'property_type' => ['required', Rule::in(array_keys(PropertyRequest::PROPERTY_TYPES))],
            'property_status' => ['required', Rule::in(array_keys(PropertyRequest::PROPERTY_STATUSES))],

            'preferred_province' => ['nullable', 'string', 'max:255'],
            'preferred_district' => ['nullable', 'string', 'max:255'],
            'preferred_sector' => ['nullable', 'string', 'max:255'],
            'location_notes' => ['nullable', 'string'],

            'currency' => ['required', Rule::in(array_keys(PropertyRequest::CURRENCIES))],
            'budget_min' => ['nullable', 'numeric', 'min:0'],
            'budget_max' => ['nullable', 'numeric', 'min:0', 'gte:budget_min'],
            'timeline' => ['required', Rule::in(array_keys(PropertyRequest::TIMELINES))],
            'financing_needed' => ['nullable', 'boolean'],

            'bedrooms_min' => ['nullable', 'integer', 'min:0', 'max:20'],
            'bathrooms_min' => ['nullable', 'integer', 'min:0', 'max:20'],
            'land_size_min' => ['nullable', 'numeric', 'min:0'],
            'land_size_max' => ['nullable', 'numeric', 'min:0', 'gte:land_size_min'],

            'amenities' => ['nullable', 'array'],
            'must_have_features' => ['nullable', 'array'],
            'nice_to_have_features' => ['nullable', 'array'],

            'additional_notes' => ['nullable', 'string'],
            'newsletter_opt_in' => ['nullable', 'boolean'],
            'how_did_you_hear' => ['nullable', 'string', 'max:255'],
            'urgency' => ['required', Rule::in(array_keys(PropertyRequest::URGENCIES))],

            'status' => ['nullable', Rule::in(array_keys(PropertyRequest::STATUSES))],
            'assigned_agent' => ['nullable', 'string', 'max:255'],
            'admin_notes' => ['nullable', 'string'],
            'is_public' => ['nullable', 'boolean'],
        ]);
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'format'     => 'required|in:excel,pdf',
            'date_range' => 'nullable|in:today,7_days,30_days,this_month,custom',
            'date_from'  => 'nullable|date',
            'date_to'    => 'nullable|date|after_or_equal:date_from',
        ]);

        $requests = $this->filteredQuery($request)->latest()->get();

        $filename = 'property-requests-' . now()->format('Y-m-d_His');

        if ($validated['format'] === 'excel') {
            return Excel::download(new PropertyRequestsExport($requests), "{$filename}.xlsx");
        }

        $pdf = Pdf::loadView('admin.property-requests.export-pdf', [
            'requests'    => $requests,
            'generatedAt' => now(),
            'filters'     => $request->only(['status', 'q', 'request_type', 'property_type', 'is_public', 'date_range', 'date_from', 'date_to']),
        ])->setPaper('a4', 'landscape');

        return $pdf->download("{$filename}.pdf");
    }

    /**
     * Shared filter logic used by both index() and export()
     * so the exported data always matches what's on screen.
     */
    private function filteredQuery(Request $request): Builder
    {
        $query = PropertyRequest::query();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('q')) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        if ($requestType = $request->get('request_type')) {
            $query->where('request_type', $requestType);
        }

        if ($propertyType = $request->get('property_type')) {
            $query->where('property_type', $propertyType);
        }

        if ($request->filled('is_public')) {
            $query->where('is_public', (bool) $request->get('is_public'));
        }

        // Date range (only relevant to the export modal; index page doesn't send this)
        switch ($request->get('date_range')) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case '7_days':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case '30_days':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'custom':
                if ($from = $request->get('date_from')) {
                    $query->whereDate('created_at', '>=', $from);
                }
                if ($to = $request->get('date_to')) {
                    $query->whereDate('created_at', '<=', $to);
                }
                break;
        }

        return $query;
    }
}
