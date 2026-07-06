<?php

namespace App\Http\Controllers\Consultants;

use App\Http\Controllers\Controller;
use App\Models\ConsultantServiceReport;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceReportController extends Controller
{
    public function create()
    {
        $consultant = Auth::user()->consultant;

        $services = $consultant->services()->where('is_active', true)->get();

        return view('consultant.service-reports.create', compact('services'));
    }

    public function store(Request $request)
    {
        $consultant = Auth::user()->consultant;

        $validated = $request->validate([
            'service_id'    => ['required', 'exists:services,id'],
            'client_name'   => ['required', 'string', 'max:255'],
            'client_phone'  => ['required', 'regex:/^(078|072|073|079)[0-9]{7}$/'],
            'service_date'  => ['required', 'date'],
            'service_time'  => ['required', 'date_format:H:i'],
            'location'      => ['required', 'string', 'max:255'],
            'amount'        => ['required', 'numeric', 'min:0'],
            'notes'         => ['nullable', 'string', 'max:1000'],
        ], [
            'client_phone.regex' => 'Enter a valid Rwandan phone number (e.g. 0788123456).',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        $terraCommission = $service->calculateCommission((float) $validated['amount']);
        $consultantAmount = $validated['amount'] - $terraCommission;

        ConsultantServiceReport::create([
            'consultant_id'          => $consultant->id,
            'service_id'             => $service->id,
            'client_name'            => $validated['client_name'],
            'client_phone'           => $validated['client_phone'],
            'service_date'           => $validated['service_date'],
            'service_time'           => $validated['service_time'],
            'location'               => $validated['location'],
            'amount'                 => $validated['amount'],
            'commission_type'        => $service->commission_type,
            'commission_value'       => $service->commission_value,
            'terra_commission_amount' => $terraCommission,
            'consultant_amount'      => $consultantAmount,
            'notes'                  => $validated['notes'] ?? null,
            'status'                 => 'pending',
        ]);

        return redirect()
            ->route('consultant.service-reports.create')
            ->with('success', 'Service report submitted successfully. Terra: ' . number_format($terraCommission) . ' RWF, You: ' . number_format($consultantAmount) . ' RWF.');
    }

    public function index()
    {
        $consultant = Auth::user()->consultant;

        $reports = $consultant->serviceReports()
            ->with('service')
            ->latest()
            ->paginate(15);

        return view('consultant.service-reports.index', compact('reports'));
    }
}