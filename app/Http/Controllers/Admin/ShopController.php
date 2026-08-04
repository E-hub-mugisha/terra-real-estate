<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreShopRequest;
use App\Models\MaterialProduct;
use App\Models\Shop;
use App\Models\User;
use App\Notifications\ShopApproved;
use App\Notifications\ShopRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\ShopOwnerWelcomeMail;
use Illuminate\Support\Facades\Mail;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::with('user')
            ->when($request->q, fn($q) => $q->where('name', 'like', "%{$request->q}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.shops.index', compact('shops'));
    }

    public function create()
    {
        return view('admin.shops.create');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'ownname'         => 'nullable|string|max:255',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'phone'           => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:255',
            'province'        => 'nullable|string|max:100',
            'district'        => 'nullable|string|max:100',
            'sector'          => 'nullable|string|max:100',
            'address'         => 'nullable|string|max:255',
            'status'          => 'required|in:pending,approved,rejected,suspended',
            'logo'            => 'nullable|image|max:2048',
            'cover_image'     => 'nullable|image|max:4096',
        ]);

        $newUser = null;
        $plainPassword = null;

        // create a new user for the shop owner if ownname is provided
        if ($request->filled('ownname')) {
            $plainPassword = Str::random(12);

            $newUser = User::create([
                'name' => $request->ownname,
                'email' => $request->email ?? Str::random(10) . '@example.com',
                'password' => Hash::make($plainPassword),
            ]);

            $validated['user_id'] = $newUser->id;
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = uniqid() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('storage/shops/logos'), $logoName);
            $validated['logo'] = 'shops/logos/' . $logoName;
        }

        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');
            $coverName = uniqid() . '_' . $cover->getClientOriginalName();
            $cover->move(public_path('storage/shops/covers'), $coverName);
            $validated['cover_image'] = 'shops/covers/' . $coverName;
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        }

        $shop = Shop::create($validated);

        // Only email if there's a real address — the auto-generated
        // @example.com fallback is not deliverable.
        if ($newUser && $request->filled('email')) {
            try {
                Mail::to($newUser->email)->send(
                    new ShopOwnerWelcomeMail($newUser, $plainPassword, $shop)
                );
            } catch (\Throwable $e) {
                report($e);
                return redirect()->route('admin.shops.show', $shop->id)
                    ->with('warning', 'Shop created, but the welcome email could not be sent.');
            }
        }

        return redirect()->route('admin.shops.show', $shop->id)->with('success', 'Shop created.');
    }

    public function edit(string $id)
    {
        $shop = Shop::findOrFail($id);

        return view('admin.shops.edit', compact('shop'));
    }

    public function update(Request $request, string $id)
    {
        $shop = Shop::findOrFail($id);

        $validated = $request->validate([
            'ownname'          => 'nullable|string|max:255',
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'phone'            => 'nullable|string|max:20',
            'whatsapp_number'  => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:255',
            'province'         => 'nullable|string|max:100',
            'district'         => 'nullable|string|max:100',
            'sector'           => 'nullable|string|max:100',
            'address'          => 'nullable|string|max:255',
            'status'           => 'required|in:pending,approved,rejected,suspended',
            'rejection_reason' => 'nullable|required_if:status,rejected|string|max:500',
            'logo'             => 'nullable|image|max:2048',
            'cover_image'      => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = uniqid() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('storage/shops/logos'), $logoName);
            $validated['logo'] = 'shops/logos/' . $logoName;
        }

        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');
            $coverName = uniqid() . '_' . $cover->getClientOriginalName();
            $cover->move(public_path('storage/shops/covers'), $coverName);
            $validated['cover_image'] = 'shops/covers/' . $coverName;
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === 'approved' && $shop->status !== 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        }

        if ($validated['status'] !== 'rejected') {
            $validated['rejection_reason'] = null;
        }

        $shop->update($validated);

        return redirect()->route('admin.shops.show', $shop->id)->with('success', 'Shop updated.');
    }

    public function show(string $id)
    {
        $shop = Shop::with(['user', 'approvedBy'])->findOrFail($id);

        $products = MaterialProduct::with(['category', 'subcategory', 'images'])
            ->where('shop_id', $shop->id)
            ->latest()
            ->paginate(10);

        return view('admin.shops.show', compact('shop', 'products'));
    }

    public function approve(string $id)
    {
        $shop = Shop::findOrFail($id);
        $shop->update([
            'status' => Shop::STATUS_APPROVED,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Shop approved.');
    }

    public function reject(Request $request, string $id)
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);

        Shop::findOrFail($id)->update([
            'status' => Shop::STATUS_REJECTED,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Shop rejected.');
    }

    public function suspend(string $id)
    {
        Shop::findOrFail($id)->update(['status' => Shop::STATUS_SUSPENDED]);

        return back()->with('success', 'Shop suspended.');
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();

        return back()->with('success', 'Shop deleted.');
    }
}
