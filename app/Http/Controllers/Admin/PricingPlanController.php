<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::latest()->paginate(10);
        return view('admin.pricing_plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.pricing_plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price_per_day' => 'required|numeric'
        ]);

        PricingPlan::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'max_images' => $request->max_images,
            'featured' => $request->featured ? 1 : 0,
            'priority_listing' => $request->priority_listing ? 1 : 0,
            'show_on_homepage' => $request->show_on_homepage ? 1 : 0,
            'active' => $request->active ? 1 : 0,
        ]);

        return redirect()->route('admin.pricing-plans.index')
            ->with('success','Plan created successfully');
    }

    public function edit(PricingPlan $pricing_plan)
    {
        return view('admin.pricing_plans.edit', compact('pricing_plan'));
    }

    public function update(Request $request, PricingPlan $pricing_plan)
    {
        $request->validate([
            'name' => 'required',
            'price_per_day' => 'required|numeric'
        ]);

        $pricing_plan->update([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'max_images' => $request->max_images,
            'featured' => $request->featured ? 1 : 0,
            'priority_listing' => $request->priority_listing ? 1 : 0,
            'show_on_homepage' => $request->show_on_homepage ? 1 : 0,
            'active' => $request->active ? 1 : 0,
        ]);

        return redirect()->route('admin.pricing-plans.index')
            ->with('success','Plan updated successfully');
    }

    public function destroy(PricingPlan $pricing_plan)
    {
        $pricing_plan->delete();

        return back()->with('success','Plan deleted');
    }

    public function createAgentPlan()
    {
        return view('admin.pricing_plans.create-agent');
    }
}