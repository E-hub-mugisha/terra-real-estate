<?php

namespace App\Http\Controllers\Consultants;

use App\Http\Controllers\Controller;
use App\Models\ConsultantServiceReport;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceReportController extends Controller
{
    // GET /consultant/service-reports/create?service_request_id=5
    public function create(Request $request)
    {
        $services = Service::orderBy('title')->get();

        $serviceRequest = null;

        if ($request->filled('service_request_id')) {
            $serviceRequest = ServiceRequest::where('id', $request->service_request_id)
                ->where('assigned_consultant_id', auth('consultant')->id())
                ->where('status', 'assigned')
                ->firstOrFail();
        }

        return view('consultant.service-reports.create', compact('services', 'serviceRequest'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_request_id' => ['nullable', 'exists:service_requests,id'],
            'service_id'         => ['required', 'exists:services,id'],
            'client_name'        => ['required', 'string', 'max:255'],
            'client_phone'       => ['required', 'string', 'max:20'],
            'service_date'       => ['required', 'date'],
            'service_time'       => ['required'],
            'location'           => ['required', 'string', 'max:255'],
            'amount'             => ['required', 'numeric', 'min:0'],
            'notes'              => ['nullable', 'string', 'max:2000'],
        ]);

        $service = Service::findOrFail($validated['service_id']);

        // Recompute commission server-side — never trust the client-side JS figure
        $amount = (float) $validated['amount'];
        $terraAmount = $service->commission_type === 'fixed'
            ? min((float) $service->commission_value, $amount)
            : $amount * ((float) $service->commission_value / 100);
        $consultantAmount = $amount - $terraAmount;

        $report = ConsultantServiceReport::create([
            ...$validated,
            'consultant_id'            => auth('consultant')->id(),
            'commission_type'          => $service->commission_type,
            'commission_value'         => $service->commission_value,
            'terra_commission_amount'  => $terraAmount,
            'consultant_amount'        => $consultantAmount,
            'status'                   => 'pending',
        ]);

        // If this report closes out a public request, mark it completed
        if (!empty($validated['service_request_id'])) {
            ServiceRequest::where('id', $validated['service_request_id'])
                ->where('assigned_consultant_id', auth('consultant')->id())
                ->update(['status' => 'completed']);
        }

        return redirect()
            ->route('consultant.service-reports.show', $report->id)
            ->with('success', 'Service report submitted for review.');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $consultantId = $user->consultant->id;
        $query = ConsultantServiceReport::where('consultant_id', $consultantId);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('service_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('service_date', '<=', $request->to);
        }

        $reports = $query->latest()->paginate(20)->withQueryString();

        return view('consultant.service-reports.index', compact('reports'));
    }

    public function show(ConsultantServiceReport $serviceReport)
    {
        

        $serviceReport->load(['service', 'serviceRequest']);

        return view('consultant.service-reports.show', compact('serviceReport'));
    }
}