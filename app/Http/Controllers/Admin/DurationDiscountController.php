<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DurationDiscount;
use Illuminate\Http\Request;

class DurationDiscountController extends Controller
{
    public function index()
    {
        $discounts = DurationDiscount::orderBy('min_days')->get();

        return view('admin.duration-discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.duration-discounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'        => 'required|string|max:255',
            'min_days'     => 'required|integer|min:1',
            'max_days'     => 'nullable|integer|gt:min_days',
            'discount_pct' => 'required|numeric|min:0|max:100',
        ]);

        // Check overlapping ranges
        $overlap = DurationDiscount::where(function ($q) use ($validated) {
            $q->where('min_days', '<=', $validated['min_days'])
              ->where(function ($q2) use ($validated) {
                  $q2->whereNull('max_days')
                     ->orWhere('max_days', '>=', $validated['min_days']);
              });
        })->orWhere(function ($q) use ($validated) {
            if (!empty($validated['max_days'])) {
                $q->where('min_days', '<=', $validated['max_days'])
                  ->where(function ($q2) use ($validated) {
                      $q2->whereNull('max_days')
                         ->orWhere('max_days', '>=', $validated['max_days']);
                  });
            }
        })->exists();

        if ($overlap) {
            return back()->withInput()->withErrors([
                'min_days' => 'This range overlaps with an existing discount. Please check the values.'
            ]);
        }

        DurationDiscount::create($validated);

        return redirect()
            ->route('admin.duration-discounts.index')
            ->with('success', 'Duration discount created successfully.');
    }

    public function show(DurationDiscount $durationDiscount)
    {
        return view('admin.duration-discounts.show', compact('durationDiscount'));
    }

    public function edit(DurationDiscount $durationDiscount)
    {
        return view('admin.duration-discounts.edit', compact('durationDiscount'));
    }

    public function update(Request $request, DurationDiscount $durationDiscount)
    {
        $validated = $request->validate([
            'label'        => 'required|string|max:255',
            'min_days'     => 'required|integer|min:1',
            'max_days'     => 'nullable|integer|gt:min_days',
            'discount_pct' => 'required|numeric|min:0|max:100',
        ]);

        // Check overlapping ranges excluding current
        $overlap = DurationDiscount::where('id', '!=', $durationDiscount->id)
            ->where(function ($q) use ($validated) {
                $q->where('min_days', '<=', $validated['min_days'])
                  ->where(function ($q2) use ($validated) {
                      $q2->whereNull('max_days')
                         ->orWhere('max_days', '>=', $validated['min_days']);
                  });
            })->orWhere(function ($q) use ($validated) {
                if (!empty($validated['max_days'])) {
                    $q->where('id', '!=', $validated['max_days'])
                      ->where('min_days', '<=', $validated['max_days'])
                      ->where(function ($q2) use ($validated) {
                          $q2->whereNull('max_days')
                             ->orWhere('max_days', '>=', $validated['max_days']);
                      });
                }
            })->exists();

        if ($overlap) {
            return back()->withInput()->withErrors([
                'min_days' => 'This range overlaps with an existing discount. Please check the values.'
            ]);
        }

        $durationDiscount->update($validated);

        return redirect()
            ->route('admin.duration-discounts.index')
            ->with('success', 'Duration discount updated successfully.');
    }

    public function destroy(DurationDiscount $durationDiscount)
    {
        $durationDiscount->delete();

        return redirect()
            ->route('admin.duration-discounts.index')
            ->with('success', 'Duration discount deleted successfully.');
    }
}