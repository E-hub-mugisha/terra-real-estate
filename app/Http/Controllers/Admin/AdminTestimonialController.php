<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminTestimonialController extends Controller
{
    // ── Index ─────────────────────────────────────────────────
 
    public function index(Request $request): View
    {
        $status = $request->get('status', 'all');
 
        $query = Testimonial::latest();
 
        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }
 
        $testimonials = $query->paginate(15)->withQueryString();
 
        $counts = [
            'all'      => Testimonial::count(),
            'pending'  => Testimonial::pending()->count(),
            'approved' => Testimonial::approved()->count(),
            'rejected' => Testimonial::where('status', 'rejected')->count(),
        ];
 
        return view('admin.testimonials.index', compact('testimonials', 'counts', 'status'));
    }
 
    // ── Store (admin-created) ─────────────────────────────────
 
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:100'],
            'email'            => ['nullable', 'email', 'max:150'],
            'location'         => ['nullable', 'string', 'max:100'],
            'transaction_type' => ['required', 'in:bought_home,sold_property,rented_home,listed_property,hired_professional,used_consultant'],
            'rating'           => ['required', 'integer', 'min:1', 'max:5'],
            'review'           => ['required', 'string', 'min:10', 'max:1000'],
            'featured'         => ['nullable', 'boolean'],
            'status'           => ['required', 'in:pending,approved,rejected'],
        ]);
 
        $testimonial = Testimonial::create([
            ...$validated,
            'featured'        => $request->boolean('featured'),
            'avatar_initials' => Testimonial::generateInitials($validated['name']),
            'source'          => 'admin',
            'approved_by'     => $validated['status'] === 'approved' ? Auth::id() : null,
            'approved_at'     => $validated['status'] === 'approved' ? now() : null,
        ]);
 
        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', "Testimonial by \"{$testimonial->name}\" created successfully.");
    }
 
    // ── Show (detail modal data — returns JSON for AJAX or full view) ──
 
    public function show(Testimonial $testimonial): View
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }
 
    // ── Update ────────────────────────────────────────────────
 
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:100'],
            'email'            => ['nullable', 'email', 'max:150'],
            'location'         => ['nullable', 'string', 'max:100'],
            'transaction_type' => ['required', 'in:bought_home,sold_property,rented_home,listed_property,hired_professional,used_consultant'],
            'rating'           => ['required', 'integer', 'min:1', 'max:5'],
            'review'           => ['required', 'string', 'min:10', 'max:1000'],
            'featured'         => ['nullable', 'boolean'],
            'status'           => ['required', 'in:pending,approved,rejected'],
            'admin_note'       => ['nullable', 'string', 'max:500'],
        ]);
 
        $wasApproved = $testimonial->status !== 'approved' && $validated['status'] === 'approved';
 
        $testimonial->update([
            ...$validated,
            'featured'        => $request->boolean('featured'),
            'avatar_initials' => Testimonial::generateInitials($validated['name']),
            'approved_by'     => $wasApproved ? Auth::id() : $testimonial->approved_by,
            'approved_at'     => $wasApproved ? now() : $testimonial->approved_at,
        ]);
 
        return redirect()
            ->route('admin.testimonials.index', ['status' => request('redirect_status', 'all')])
            ->with('success', "Testimonial updated successfully.");
    }
 
    // ── Destroy ───────────────────────────────────────────────
 
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $name = $testimonial->name;
        $testimonial->delete();
 
        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', "Testimonial by \"{$name}\" deleted.");
    }
 
    // ── Quick actions ─────────────────────────────────────────
 
    public function approve(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update([
            'status'      => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
 
        return back()->with('success', "\"{$testimonial->name}\" approved and published.");
    }
 
    public function reject(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update([
            'status'     => 'rejected',
            'admin_note' => $request->input('admin_note'),
        ]);
 
        return back()->with('success', "\"{$testimonial->name}\" rejected.");
    }
 
    public function toggleFeatured(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['featured' => ! $testimonial->featured]);
 
        $label = $testimonial->featured ? 'featured' : 'unfeatured';
        return back()->with('success', "\"{$testimonial->name}\" is now {$label}.");
    }
}
