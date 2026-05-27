<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequestRequest;
use App\Mail\PropertyRequestAdminNotification;
use App\Mail\PropertyRequestClientConfirmation;
use App\Models\PropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PropertyRequestController extends Controller
{
    /**
     * Show the multistep form.
     */
    public function create()
    {
        return view('property-request.create');
    }

    /**
     * Validate & store the request, then send emails.
     */
    public function store(StorePropertyRequestRequest $request)
    {
        $validated = $request->validated();

        // Normalise checkbox arrays — unchecked boxes send nothing
        $validated['amenities']             = $validated['amenities']             ?? [];
        $validated['must_have_features']    = $validated['must_have_features']    ?? [];
        $validated['nice_to_have_features'] = $validated['nice_to_have_features'] ?? [];

        $propertyRequest = PropertyRequest::create($validated);

        // ── Notify admin ──────────────────────────────────────────
        try {
            Mail::to(config('terra.admin_email', 'admin@terra.rw'))
                ->send(new PropertyRequestAdminNotification($propertyRequest));
        } catch (\Throwable $e) {
            Log::error('Terra admin notification failed: ' . $e->getMessage(), [
                'reference' => $propertyRequest->reference_number,
            ]);
        }

        // ── Confirm to client ──────────────────────────────────────
        try {
            Mail::to($propertyRequest->email)
                ->send(new PropertyRequestClientConfirmation($propertyRequest));
        } catch (\Throwable $e) {
            Log::error('Terra client confirmation failed: ' . $e->getMessage(), [
                'reference' => $propertyRequest->reference_number,
            ]);
        }

        return redirect()
            ->route('property-request.success', ['ref' => $propertyRequest->reference_number])
            ->with('success', 'Your property request has been submitted successfully!');
    }

    /**
     * Success / thank-you page.
     */
    public function success(Request $request)
    {
        $ref = $request->query('ref');
        $propertyRequest = $ref
            ? PropertyRequest::where('reference_number', $ref)->firstOrFail()
            : null;

        return view('property-request.success', compact('propertyRequest'));
    }
}
