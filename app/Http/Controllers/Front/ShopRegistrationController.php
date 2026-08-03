<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopRegistrationRequest;
use App\Models\Shop;
use App\Notifications\ShopRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ShopRegistrationController extends Controller
{
    public function create()
    {
        $existing = Shop::where('user_id', auth()->id())->first();

        if ($existing) {
            return redirect()
                ->route('shops.register.status')
                ->with('shop', $existing);
        }

        return view('shops.register');
    }

    public function store(StoreShopRegistrationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = Shop::STATUS_PENDING;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('shops/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('shops/covers', 'public');
        }

        $shop = Shop::create($data);

        // Notify all admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ShopRegistered($shop));
        }

        return redirect()
            ->route('shops.register.status')
            ->with('success', 'Your shop registration has been submitted and is pending admin approval.');
    }

    public function status()
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();

        return view('shops.register-status', compact('shop'));
    }
}