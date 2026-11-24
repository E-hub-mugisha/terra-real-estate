<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Services\Marketplace\CommissionService;
use Illuminate\Http\Request;

/**
 * Leads: owners/clients referred by partners (and agents), with status tracking.
 * Agents also see inquiries on their listings as leads.
 */
class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $referrals = $user->referrals()
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->when($request->query('type'), fn ($q, $t) => $q->where('type', $t))
            ->latest()->paginate(20)->withQueryString();

        $pipeline = $user->referrals()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $inquiryLeads = $user->inquiriesReceived()->with('listable')->latest()->take(8)->get();

        return view('room.referrals.index', compact('referrals', 'pipeline', 'inquiryLeads'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:owner,client',
            'name' => 'required|string|max:150',
            'phone' => 'required_without:email|nullable|string|max:30',
            'email' => 'required_without:phone|nullable|email|max:150',
            'interest' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);
        $request->user()->referrals()->create($data + ['status' => 'new']);

        return back()->with('success', 'Referral added. The Terra team will follow up.');
    }

    public function update(Request $request, Referral $referral)
    {
        $user = $request->user();
        abort_unless($referral->referrer_id === $user->id || $user->isStaff(), 403);
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', Referral::STATUSES),
            'notes' => 'nullable|string|max:1000',
        ]);
        // Only Terra staff can confirm a conversion (it triggers a partner reward).
        if ($data['status'] === 'converted' && !$user->isStaff()) {
            return back()->with('warning', 'Conversions are confirmed by the Terra team.');
        }
        $referral->update($data);
        if ($referral->status === 'converted') {
            app(CommissionService::class)->forReferral($referral);
        }

        return back()->with('success', 'Lead updated.');
    }
}
