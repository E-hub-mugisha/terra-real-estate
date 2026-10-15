<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantApplication;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    /**
     * Display applications belonging to the logged-in tenant.
     */
    public function index()
    {
        $tenant = $this->getTenant();

        $applications = TenantApplication::with([
                'unit',
                'reviewer',
            ])
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->paginate(10);

        return view('tenant-portal.applications.index', compact(
            'applications'
        ));
    }

    /**
     * Show available units and the application form.
     */
    public function create(Request $request)
    {
        $tenant = $this->getTenant();

        $units = Unit::query()
            ->whereDoesntHave('applications', function ($query) use ($tenant) {
                $query->where('tenant_id', $tenant->id)
                    ->whereIn('status', ['pending', 'under_review', 'approved']);
            })
            ->get();

        $selectedUnit = $request->filled('unit_id')
            ? $units->firstWhere('id', (int) $request->unit_id)
            : null;

        return view('tenant-portal.applications.create', compact(
            'units',
            'selectedUnit'
        ));
    }

    /**
     * Save a tenant application.
     */
    public function store(Request $request)
    {
        $tenant = $this->getTenant();

        $validated = $request->validate([
            'unit_id' => [
                'required',
                'integer',
                Rule::exists('units', 'id'),
            ],
            'desired_move_in_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'number_of_occupants' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
            'offered_monthly_rent' => [
                'required',
                'numeric',
                'min:0',
            ],
            'currency' => [
                'required',
                Rule::in(['RWF', 'USD']),
            ],
            'employment_status' => [
                'nullable',
                'string',
                'max:100',
            ],
            'additional_information' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $unit = Unit::findOrFail($validated['unit_id']);

        $duplicate = TenantApplication::where('tenant_id', $tenant->id)
            ->where('unit_id', $unit->id)
            ->whereIn('status', ['pending', 'under_review', 'approved'])
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'unit_id' => 'You already have an active application for this unit.',
                ]);
        }

        $application = DB::transaction(function () use (
            $tenant,
            $unit,
            $validated
        ) {
            return TenantApplication::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $unit->id,
                'application_number' => 'TA-' . now()->format('Ymd') . '-'
                    . strtoupper(Str::random(8)),
                'application_date' => today(),
                'desired_move_in_date' => $validated['desired_move_in_date'],
                'number_of_occupants' => $validated['number_of_occupants'],
                'offered_monthly_rent' => $validated['offered_monthly_rent'],
                'currency' => $validated['currency'],
                'employment_status' => $validated['employment_status'] ?? null,
                'additional_information' => $validated['additional_information'] ?? null,
                'status' => 'pending',
            ]);
        });

        return redirect()
            ->route('tenant-portal.applications.show', $application)
            ->with('success', 'Your rental application has been submitted successfully.');
    }

    /**
     * Display an application belonging to the logged-in tenant.
     */
    public function show(TenantApplication $application)
    {
        $tenant = $this->getTenant();

        abort_unless(
            (int) $application->tenant_id === (int) $tenant->id,
            403
        );

        $application->load(['unit', 'reviewer']);

        return view('tenant-portal.applications.show', compact(
            'application'
        ));
    }

    /**
     * Resolve the tenant associated with the authenticated user.
     */
    private function getTenant(): Tenant
    {
        return Tenant::where('user_id', auth()->id())->firstOrFail();
    }
}