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
        $request->validate([
            'order_id' => 'required'
        ]);

        $order = PropertyPlanOrder::findOrFail($request->order_id);
        $ref = 'TERRA-' . strtoupper(uniqid());
        
        // Save phone
        $order->payment()->create([
            'amount' => $order->total_price,
            'payment_method' => 'MoMo',
            'transaction_id' => $ref,
            'status' => 'success',
        ]);

        $order->update(['payment_status' => 'paid']);

        // Example message
        return redirect()->route('front.home')->with(
            'success',
            'Payment request sent. Dial *182*8*1# and enter merchant code 511725 to complete payment.'
        );
    }
}
