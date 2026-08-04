<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $shop = $request->user()->shop;

        return view('shop-panel.profile.show', compact('shop'));
    }
    public function edit(Request $request)
    {
        $shop = $request->user()->shop;

        return view('shop-panel.profile.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = $request->user()->shop;

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'phone'           => ['nullable', 'string', 'regex:/^(07[2-9])\d{7}$/'],
            'whatsapp_number' => ['nullable', 'string', 'regex:/^(07[2-9])\d{7}$/'],
            'email'           => ['nullable', 'email'],
            'province'        => ['nullable', 'string', 'max:100'],
            'district'        => ['nullable', 'string', 'max:100'],
            'sector'          => ['nullable', 'string', 'max:100'],
            'address'         => ['nullable', 'string', 'max:255'],
            'logo'            => ['nullable', 'image', 'max:2048'],
            'cover_image'     => ['nullable', 'image', 'max:4096'],
        ], [
            'phone.regex'           => 'Enter a valid Rwandan number, e.g. 0788123456.',
            'whatsapp_number.regex' => 'Enter a valid Rwandan WhatsApp number, e.g. 0788123456.',
        ]);

        if ($request->hasFile('logo')) {
            if ($shop->logo) Storage::disk('public')->delete($shop->logo);
            $validated['logo'] = $request->file('logo')->store('shops/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($shop->cover_image) Storage::disk('public')->delete($shop->cover_image);
            $validated['cover_image'] = $request->file('cover_image')->store('shops/covers', 'public');
        }

        // Editing key details on an already-approved shop sends it back for re-review.
        if ($shop->status === \App\Models\Shop::STATUS_APPROVED) {
            $validated['status'] = \App\Models\Shop::STATUS_PENDING;
            $validated['rejection_reason'] = null;
        }

        $shop->update($validated);

        return back()->with('status', 'shop-updated');
    }
}
