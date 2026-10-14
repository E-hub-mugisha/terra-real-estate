<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\ManagedProperty;
use App\Models\PropertyExpense;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PropertyExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = PropertyExpense::with([
            'managedProperty',
            'unit',
            'recorder',
        ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);

                $query->where(function ($q) use ($search) {
                    $q->where('expense_reference', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('vendor_name', 'like', "%{$search}%")
                        ->orWhereHas('managedProperty', function ($propertyQuery) use ($search) {
                            $propertyQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('property_code', 'like', "%{$search}%");
                        })
                        ->orWhereHas('unit', function ($unitQuery) use ($search) {
                            $unitQuery->where('unit_number', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('property_id'), function ($query) use ($request) {
                $query->where('managed_property_id', $request->property_id);
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('from'), function ($query) use ($request) {
                $query->whereDate('expense_date', '>=', $request->from);
            })
            ->when($request->filled('to'), function ($query) use ($request) {
                $query->whereDate('expense_date', '<=', $request->to);
            })
            ->latest('expense_date')
            ->paginate(15)
            ->withQueryString();

        $properties = ManagedProperty::orderBy('name')->get([
            'id',
            'name',
        ]);

        $categories = PropertyExpense::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view(
            'admin.property-management.expenses.index',
            compact('expenses', 'properties', 'categories')
        );
    }

    public function create()
    {
        $expense = new PropertyExpense([
            'currency' => 'RWF',
            'expense_date' => now()->toDateString(),
            'status' => 'recorded',
        ]);

        $properties = ManagedProperty::orderBy('name')->get();
        $units = Unit::with('managedProperty')->orderBy('unit_number')->get();

        return view(
            'admin.property-management.expenses.create',
            compact('expense', 'properties', 'units')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateExpense($request);

        $validated['expense_reference'] = $this->generateExpenseReference();
        $validated['recorded_by'] = auth()->id();
        $validated['status'] = 'recorded';

        if ($request->hasFile('receipt')) {
            $validated['receipt_path'] = $request->file('receipt')
                ->store('property-expenses/receipts', 'public');
        }

        unset($validated['receipt']);

        $expense = PropertyExpense::create($validated);

        return redirect()
            ->route('admin.property-management.expenses.show', $expense)
            ->with('success', 'Property expense recorded successfully.');
    }

    public function show(PropertyExpense $expense)
    {
        $expense->load([
            'managedProperty.owner.user',
            'unit',
            'recorder',
        ]);

        return view(
            'admin.property-management.expenses.show',
            compact('expense')
        );
    }

    public function edit(PropertyExpense $expense)
    {
        $properties = ManagedProperty::orderBy('name')->get();
        $units = Unit::with('managedProperty')->orderBy('unit_number')->get();

        return view(
            'admin.property-management.expenses.edit',
            compact('expense', 'properties', 'units')
        );
    }

    public function update(Request $request, PropertyExpense $expense)
    {
        $validated = $this->validateExpense($request, $expense);
        $oldReceiptPath = $expense->receipt_path;
        $newReceiptPath = null;

        if ($request->hasFile('receipt')) {
            $newReceiptPath = $request->file('receipt')
                ->store('property-expenses/receipts', 'public');

            $validated['receipt_path'] = $newReceiptPath;
        }

        try {
            unset($validated['receipt']);

            $expense->update($validated);
        } catch (\Throwable $exception) {
            if ($newReceiptPath) {
                Storage::disk('public')->delete($newReceiptPath);
            }

            throw $exception;
        }

        if ($newReceiptPath && $oldReceiptPath) {
            Storage::disk('public')->delete($oldReceiptPath);
        }

        return redirect()
            ->route('admin.property-management.expenses.show', $expense)
            ->with('success', 'Property expense updated successfully.');
    }

    public function destroy(PropertyExpense $expense)
    {
        $receiptPath = $expense->receipt_path;

        $expense->delete();

        if ($receiptPath) {
            Storage::disk('public')->delete($receiptPath);
        }

        return redirect()
            ->route('admin.property-management.expenses.index')
            ->with('success', 'Property expense deleted successfully.');
    }

    private function validateExpense(
        Request $request,
        ?PropertyExpense $expense = null
    ): array {
        $validated = $request->validate([
            'managed_property_id' => [
                'required',
                'integer',
                'exists:managed_properties,id',
            ],
            'unit_id' => [
                'nullable',
                'integer',
                'exists:units,id',
            ],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:2000'],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:999999999999.99',
            ],
            'currency' => ['required', Rule::in(['RWF', 'USD'])],
            'expense_date' => ['required', 'date'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'receipt' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        if (! empty($validated['unit_id'])) {
            $unitBelongsToProperty = Unit::whereKey($validated['unit_id'])
                ->where('managed_property_id', $validated['managed_property_id'])
                ->exists();

            if (! $unitBelongsToProperty) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'unit_id' => 'The selected unit does not belong to this property.',
                ]);
            }
        }

        return $validated;
    }

    private function generateExpenseReference(): string
    {
        do {
            $reference = 'EXP-' . now()->format('Ymd') . '-'
                . strtoupper(bin2hex(random_bytes(4)));
        } while (
            PropertyExpense::where('expense_reference', $reference)->exists()
        );

        return $reference;
    }

    public function receipt(PropertyExpense $expense)
    {
        abort_unless($expense->receipt_path, 404);

        abort_unless(
            Storage::disk('public')->exists($expense->receipt_path),
            404,
            'The supporting document could not be found.'
        );

        return Storage::disk('public')->response(
            $expense->receipt_path
        );
    }
}
