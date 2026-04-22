<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultantCommissionTier;
use Illuminate\Http\Request;

class ConsultantCommissionTierController extends Controller
{
    // List all tiers
    public function index()
    {
        $tiers = ConsultantCommissionTier::orderBy('min_value')->get();

        return view('admin.commission-tiers.index', compact('tiers'));
    }

    // Show create form
    public function create()
    {
        return view('admin.commission-tiers.create');
    }

    // Store new tier
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'                 => 'required|string|max:255',
            'min_value'             => 'required|integer|min:0',
            'max_value'             => 'nullable|integer|gt:min_value',
            'terra_commission_pct'  => 'required|numeric|min:0|max:100',
            'consultant_payout_pct' => 'required|numeric|min:0|max:100',
        ]);

        // Check for overlapping ranges
        $overlap = ConsultantCommissionTier::where(function ($q) use ($validated) {
            $q->where('min_value', '<=', $validated['min_value'])
              ->where(function ($q2) use ($validated) {
                  $q2->whereNull('max_value')
                     ->orWhere('max_value', '>=', $validated['min_value']);
              });
        })->orWhere(function ($q) use ($validated) {
            if (!empty($validated['max_value'])) {
                $q->where('min_value', '<=', $validated['max_value'])
                  ->where(function ($q2) use ($validated) {
                      $q2->whereNull('max_value')
                         ->orWhere('max_value', '>=', $validated['max_value']);
                  });
            }
        })->exists();

        if ($overlap) {
            return back()->withInput()->withErrors([
                'min_value' => 'This range overlaps with an existing tier. Please check the values.'
            ]);
        }

        ConsultantCommissionTier::create($validated);

        return redirect()
            ->route('admin.commission-tiers.index')
            ->with('success', 'Commission tier created successfully.');
    }

    // Show single tier
    public function show(ConsultantCommissionTier $commissionTier)
    {
        return view('admin.commission-tiers.show', compact('commissionTier'));
    }

    // Show edit form
    public function edit(ConsultantCommissionTier $commissionTier)
    {
        return view('admin.commission-tiers.edit', compact('commissionTier'));
    }

    // Update tier
    public function update(Request $request, ConsultantCommissionTier $commissionTier)
    {
        $validated = $request->validate([
            'label'                 => 'required|string|max:255',
            'min_value'             => 'required|integer|min:0',
            'max_value'             => 'nullable|integer|gt:min_value',
            'terra_commission_pct'  => 'required|numeric|min:0|max:100',
            'consultant_payout_pct' => 'required|numeric|min:0|max:100',
        ]);

        // Check for overlapping ranges excluding current record
        $overlap = ConsultantCommissionTier::where('id', '!=', $commissionTier->id)
            ->where(function ($q) use ($validated) {
                $q->where('min_value', '<=', $validated['min_value'])
                  ->where(function ($q2) use ($validated) {
                      $q2->whereNull('max_value')
                         ->orWhere('max_value', '>=', $validated['min_value']);
                  });
            })->orWhere(function ($q) use ($validated) {
                if (!empty($validated['max_value'])) {
                    $q->where('id', '!=', $validated['max_value'])
                      ->where('min_value', '<=', $validated['max_value'])
                      ->where(function ($q2) use ($validated) {
                          $q2->whereNull('max_value')
                             ->orWhere('max_value', '>=', $validated['max_value']);
                      });
                }
            })->exists();

        if ($overlap) {
            return back()->withInput()->withErrors([
                'min_value' => 'This range overlaps with an existing tier. Please check the values.'
            ]);
        }

        $commissionTier->update($validated);

        return redirect()
            ->route('admin.commission-tiers.index')
            ->with('success', 'Commission tier updated successfully.');
    }

    // Delete tier
    public function destroy(ConsultantCommissionTier $commissionTier)
    {
        $commissionTier->delete();

        return redirect()
            ->route('admin.commission-tiers.index')
            ->with('success', 'Commission tier deleted successfully.');
    }
}
