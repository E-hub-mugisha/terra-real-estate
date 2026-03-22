<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentCommission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = AgentCommission::with(['agent.user', 'listingPackage', 'agentLevel', 'commissionable'])
            ->latest()
            ->paginate(25);

        $totals = [
            'pending'  => AgentCommission::where('listing_commission_status', 'pending')->sum('listing_commission'),
            'approved' => AgentCommission::where('listing_commission_status', 'approved')->sum('listing_commission'),
            'paid'     => AgentCommission::where('listing_commission_status', 'paid')->sum('listing_commission'),
        ];

        return view('admin.commissions.index', compact('commissions', 'totals'));
    }

    public function show(AgentCommission $commission)
    {
        $commission->load(['agent.user', 'listingPackage', 'agentLevel', 'commissionable']);

        // Timeline: build a chronological activity log from model data
        $timeline = collect();

        $timeline->push([
            'icon'  => 'created',
            'label' => 'Commission record created',
            'date'  => $commission->created_at,
            'color' => 'blue',
        ]);

        if ($commission->listing_commission_status === 'approved' || $commission->listing_commission_status === 'paid') {
            $timeline->push([
                'icon'  => 'approved',
                'label' => 'Listing commission approved',
                'date'  => $commission->updated_at,
                'color' => 'indigo',
            ]);
        }

        if ($commission->listing_commission_paid_at) {
            $timeline->push([
                'icon'  => 'paid',
                'label' => 'Listing commission paid out',
                'date'  => $commission->listing_commission_paid_at,
                'color' => 'green',
            ]);
        }

        if ($commission->sale_commission_status === 'approved' || $commission->sale_commission_status === 'paid') {
            $timeline->push([
                'icon'  => 'approved',
                'label' => 'Sale commission approved',
                'date'  => $commission->updated_at,
                'color' => 'indigo',
            ]);
        }

        if ($commission->sale_commission_paid_at) {
            $timeline->push([
                'icon'  => 'paid',
                'label' => 'Sale commission paid out',
                'date'  => $commission->sale_commission_paid_at,
                'color' => 'green',
            ]);
        }

        $timeline = $timeline->sortBy('date')->values();

        return view('admin.commissions.show', compact('commission', 'timeline'));
    }

    public function approve(AgentCommission $commission)
    {
        $commission->update([
            'listing_commission_status' => 'approved',
        ]);

        return back()->with('success', 'Listing commission approved successfully.');
    }

    public function markPaid(AgentCommission $commission, Request $request)
    {
        $request->validate([
            'type' => 'required|in:listing,sale',
        ]);

        if ($request->type === 'listing') {
            $commission->update([
                'listing_commission_status'  => 'paid',
                'listing_commission_paid_at' => now(),
            ]);
        } else {
            $commission->update([
                'sale_commission_status'  => 'paid',
                'sale_commission_paid_at' => now(),
            ]);
        }

        return back()->with('success', ucfirst($request->type) . ' commission marked as paid.');
    }

    public function destroy(AgentCommission $commission)
    {
        $commission->delete();

        return redirect()
            ->route('admin.commissions.index')
            ->with('success', 'Commission record deleted.');
    }
}