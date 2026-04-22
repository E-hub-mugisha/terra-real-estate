<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyPlanOrder;
use Illuminate\Http\Request;

class AdminPropertyPlanController extends Controller
{
    public function index()
    {
        // Load property, user, plan, and payment details
        $orders = PropertyPlanOrder::with(['user', 'plan', 'property', 'payment'])->latest()->get();
        return view('admin.property.property-plan-orders', compact('orders'));
    }

    public function approve(PropertyPlanOrder $order)
    {
        if ($order->payment && $order->payment->status === 'success') {
            $order->update([
                'is_approved' => true, // make sure you have this column in property_plan_orders
            ]);

            return back()->with('success', 'Property approved successfully.');
        }

        return back()->with('error', 'Cannot approve unpaid property.');
    }
}
