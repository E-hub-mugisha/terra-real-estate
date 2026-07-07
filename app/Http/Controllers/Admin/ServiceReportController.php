<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultantServiceReport;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceReportController extends Controller
{
    public function index(Request $request)
    {
        $query = ConsultantServiceReport::with(['consultant', 'service']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('consultant_id')) {
            $query->where('consultant_id', $request->consultant_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('service_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('service_date', '<=', $request->to);
        }

        $reports = $query->latest()->paginate(20)->withQueryString();

        $totals = [
            'total_amount'     => ConsultantServiceReport::sum('amount'),
            'terra_commission' => ConsultantServiceReport::sum('terra_commission_amount'),
            'consultant_paid'  => ConsultantServiceReport::where('status', 'approved')->sum('consultant_amount'),
            'pending_count'    => ConsultantServiceReport::pending()->count(),
        ];

        return view('admin.service-reports.index', compact('reports', 'totals'));
    }

    public function show(ConsultantServiceReport $serviceReport)
    {
        $serviceReport->load(['consultant', 'service']);

        return view('admin.service-reports.show', compact('serviceReport'));
    }

    public function updateStatus(Request $request, ConsultantServiceReport $serviceReport)
    {
        $validated = $request->validate([
            'status'      => ['required', 'in:approved,rejected'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $serviceReport->update([
            'status'      => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Report marked as ' . $validated['status'] . '.');
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