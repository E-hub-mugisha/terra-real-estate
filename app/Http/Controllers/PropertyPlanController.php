<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use App\Models\PropertyPlanOrder;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyPlanController extends Controller
{

    public function selectPlan($type, $id)
    {
        $plans = PricingPlan::where('active', 1)->get();

        return view('front.plans.select', compact('plans', 'type', 'id'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:pricing_plans,id',
            'days' => 'required|integer|min:1',
            'property_id' => 'required',
            'property_type' => 'required'
        ]);

        $plan = PricingPlan::findOrFail($request->plan_id);

        switch ($request->property_type) {

            case 'house':
                $model = \App\Models\House::class;
                break;

            case 'land':
                $model = \App\Models\Land::class;
                break;

            case 'design':
                $model = \App\Models\ArchitecturalDesign::class;
                break;

            default:
                abort(404);
        }

        $total = $plan->price_per_day * $request->days;

        $property = $model::findOrFail($request->property_id);

        // user with property plan order
        $user = User::where('id', $property->user_id)->first();

        $order = PropertyPlanOrder::create([
            'user_id' => $user->id,
            'pricing_plan_id' => $plan->id,
            'property_id' => $request->property_id,
            'property_type' => $model,
            'days' => $request->days,
            'price_per_day' => $plan->price_per_day,
            'total_price' => $total,
            'payment_status' => 'pending'
        ]);

        return redirect()->route('plans.payment', $order->id);
    }


    public function payment(PropertyPlanOrder $order)
    {
        return view('front.plans.payment', compact('order'));
    }

    public function payMomo(Request $request)
    {
        $request->validate(['order_id' => 'required']);

        $order = PropertyPlanOrder::findOrFail($request->order_id);
        $ref   = 'TERRA-' . strtoupper(uniqid());

        $order->payment()->create([
            'amount'         => $order->total_price,
            'payment_method' => 'MoMo',
            'transaction_id' => $ref,
            'status'         => 'success',
        ]);

        $order->update(['payment_status' => 'paid']);

        $role         = strtolower(auth()->user()->role); // normalize casing
        $propertyId   = $order->property_id;
        $propertyType = $order->property_type;            // check DD what this actually is

        // Support both short strings AND full class names
        $typeMap = [
            // Short strings (if stored as 'house', 'land', 'design')
            'house'  => 'houses',
            'land'   => 'lands',
            'design' => 'designs',
            // Full class names (if stored as App\Models\House etc.)
            \App\Models\House::class               => 'houses',
            \App\Models\Land::class                => 'lands',
            \App\Models\ArchitecturalDesign::class => 'designs',
        ];

        $segment = $typeMap[$propertyType] ?? null;

        if ($segment && in_array($role, ['admin', 'agent'])) {
            $routeName = "{$role}.properties.{$segment}.show";

            if (\Illuminate\Support\Facades\Route::has($routeName)) {
                return redirect()
                    ->route($routeName, $propertyId)
                    ->with('success', 'Payment successful! Your property is now under review.');
            }

            // Route not found — log it so you can see what name was attempted
            \Illuminate\Support\Facades\Log::warning("Redirect route not found: {$routeName}");
        }

        return redirect()
            ->route('front.home')
            ->with('success', 'Payment request sent. Dial *182*8*1# and enter merchant code 511725 to complete payment.');
    }
}
