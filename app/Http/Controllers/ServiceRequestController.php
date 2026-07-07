<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function create()
    {
        $services = Service::orderBy('title')->get();

        return view('front.service-request-create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'      => ['required', 'exists:services,id'],
            'full_name'       => ['required', 'string', 'max:255'],
            'phone'           => ['required', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:255'],
            'location'        => ['required', 'string', 'max:255'],
            'preferred_date'  => ['required', 'date', 'after_or_equal:today'],
            'preferred_time'  => ['required'],
            'message'         => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['status'] = 'new';

        ServiceRequest::create($validated);

        return redirect()
            ->route('service-requests.create')
            ->with('success', 'Your request has been received. A Terra consultant will contact you shortly.');
    }
}