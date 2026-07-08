<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\ConsultantServiceReport;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceRequestAdminController extends Controller
{
    public function index()
    {
        $requests = ServiceRequest::with(['service', 'consultant'])
            ->latest()
            ->paginate(15);

        $consultants = Consultant::orderBy('id')->get();

        return view('admin.service-requests.index', compact('requests', 'consultants'));
    }

    public function assign(Request $request, $id)
    {
        $validated = $request->validate([
            'consultant_id' => ['required', 'exists:consultants,id'],
        ]);

        $serviceRequest = ServiceRequest::with('service')->findOrFail($id);

        // Prevent re-assigning an already-assigned request from creating duplicate reports
        if ($serviceRequest->report()->exists()) {
            return redirect()
                ->route('admin.service-requests.index')
                ->with('error', 'This request already has a service report and cannot be reassigned this way.');
        }

        DB::transaction(function () use ($serviceRequest, $validated) {
            $serviceRequest->update([
                'assigned_consultant_id' => $validated['consultant_id'],
                'status' => 'assigned',
            ]);

            $service = $serviceRequest->service;

            // Use the service's listed price as the starting amount — consultant
            // will confirm/adjust the real charged amount when filing the report.
            $startingAmount = $service->price ?? 0;
            $terraCommission = $service->calculateCommission((float) $startingAmount);
            $consultantAmount = $startingAmount - $terraCommission;

            ConsultantServiceReport::create([
                'consultant_id'           => $validated['consultant_id'],
                'service_id'              => $service->id,
                'service_request_id'      => $serviceRequest->id,

                // Auto-filled from the original client request
                'client_name'             => $serviceRequest->full_name,
                'client_phone'            => $serviceRequest->phone,
                'service_date'            => $serviceRequest->preferred_date,
                'service_time'            => $serviceRequest->preferred_time,
                'location'                => $serviceRequest->location,

                'amount'                  => $startingAmount,
                'commission_type'         => $service->commission_type,
                'commission_value'        => $service->commission_value,
                'terra_commission_amount' => $terraCommission,
                'consultant_amount'       => $consultantAmount,

                'status'                  => 'draft',
                'notes'                   => $serviceRequest->message,
            ]);
        });

        // Optional: notify the consultant here, e.g.
        // $serviceRequest->consultant->user->notify(new ServiceRequestAssigned($serviceRequest));

        return redirect()
            ->route('admin.service-requests.index')
            ->with('success', 'Consultant assigned and a draft service report was created from the client request.');
    }

    public function cancel($id)
    {
        ServiceRequest::findOrFail($id)->update(['status' => 'cancelled']);

        return redirect()
            ->route('admin.service-requests.index')
            ->with('success', 'Request marked as cancelled.');
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['service', 'consultant.user', 'report']);
        $consultants = Consultant::with('user')->get(); // whatever scope you already use on index

        return view('admin.service-requests.show', compact('serviceRequest', 'consultants'));
    }
}
