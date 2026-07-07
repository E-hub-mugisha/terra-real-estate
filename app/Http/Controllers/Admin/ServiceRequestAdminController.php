<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

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

        $serviceRequest = ServiceRequest::findOrFail($id);

        $serviceRequest->update([
            'assigned_consultant_id' => $validated['consultant_id'],
            'status' => 'assigned',
        ]);

        // Optional: notify the consultant here, e.g.
        // $serviceRequest->consultant->user->notify(new ServiceRequestAssigned($serviceRequest));

        return redirect()
            ->route('admin.service-requests.index')
            ->with('success', 'Consultant assigned to the request.');
    }

    public function cancel($id)
    {
        ServiceRequest::findOrFail($id)->update(['status' => 'cancelled']);

        return redirect()
            ->route('admin.service-requests.index')
            ->with('success', 'Request marked as cancelled.');
    }
}