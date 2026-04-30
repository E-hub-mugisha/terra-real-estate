<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Store a new testimonial submitted by a site visitor.
     * Status defaults to 'pending' — admin must approve before it shows publicly.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:100'],
            'email'            => ['nullable', 'email', 'max:150'],
            'location'         => ['nullable', 'string', 'max:100'],
            'transaction_type' => ['required', 'in:bought_home,sold_property,rented_home,listed_property,hired_professional,used_consultant'],
            'rating'           => ['required', 'integer', 'min:1', 'max:5'],
            'review'           => ['required', 'string', 'min:20', 'max:1000'],
        ]);

        Testimonial::create([
            ...$validated,
            'avatar_initials' => Testimonial::generateInitials($validated['name']),
            'status'          => 'pending',
            'source'          => 'website',
        ]);

        return redirect()
            ->back()
            ->with('testimonial_submitted', true);
    }

    /**
     * Optional stand-alone thank-you page.
     */
    public function thankYou(): View
    {
        return view('front.testimonials.thankyou');
    }
}