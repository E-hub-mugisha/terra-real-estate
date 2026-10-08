<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\RentInvoice;
use App\Models\RentLedgerEntries;
use App\Models\RentLedgerEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RentInvoiceController extends Controller
{
    /**
     * Display invoices.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = RentInvoice::query()
            ->with([
                'tenant',
                'lease',
                'unit.floor.building.property',
            ])
            ->whereHas('unit.floor.building.property', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")

                    ->orWhereHas('tenant', function ($tenantQuery) use ($search) {

                        $tenantQuery
                            ->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Invoice type
        |--------------------------------------------------------------------------
        */

        if ($request->filled('invoice_type')) {
            $query->where('invoice_type', $request->invoice_type);
        }

        /*
        |--------------------------------------------------------------------------
        | Date range
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {
            $query->whereDate('issue_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('issue_date', '<=', $request->date_to);
        }

        $invoices = $query
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $summaryQuery = RentInvoice::query()
            ->whereHas('unit.floor.building.property', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });

        $totalInvoiced = (clone $summaryQuery)
            ->where('status', '!=', 'cancelled')
            ->sum('amount');

        $totalPaid = (clone $summaryQuery)
            ->where('status', '!=', 'cancelled')
            ->sum('paid_amount');

        $totalOutstanding = (clone $summaryQuery)
            ->where('status', '!=', 'cancelled')
            ->sum('balance');

        $overdueCount = (clone $summaryQuery)
            ->whereIn('status', [
                'issued',
                'partially_paid',
                'overdue',
            ])
            ->whereDate('due_date', '<', now()->toDateString())
            ->where('balance', '>', 0)
            ->count();

        return view(
            'property-management.invoices.index',
            compact(
                'invoices',
                'totalInvoiced',
                'totalPaid',
                'totalOutstanding',
                'overdueCount'
            )
        );
    }

    /**
     * Show invoice creation form.
     */
    public function create(Request $request)
    {
        $userId = Auth::id();

        $leases = Lease::query()
            ->with([
                'tenant',
                'unit.floor.building.property',
            ])
            ->where('status', 'active')
            ->whereHas('unit.floor.building.property', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('id', 'desc')
            ->get();

        $selectedLease = null;

        if ($request->filled('lease')) {

            $selectedLease = $leases->firstWhere(
                'id',
                (int) $request->lease
            );
        }

        return view(
            'property-management.invoices.create',
            compact(
                'leases',
                'selectedLease'
            )
        );
    }

    /**
     * Store invoice.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'lease_id' => [
                'required',
                'integer',
                'exists:leases,id',
            ],

            'invoice_type' => [
                'required',
                'in:rent,deposit,service_charge,other',
            ],

            'description' => [
                'required',
                'string',
                'max:255',
            ],

            'billing_period_start' => [
                'nullable',
                'date',
            ],

            'billing_period_end' => [
                'nullable',
                'date',
                'after_or_equal:billing_period_start',
            ],

            'issue_date' => [
                'required',
                'date',
            ],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:issue_date',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'status' => [
                'required',
                'in:draft,issued',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $lease = Lease::query()
            ->with([
                'tenant',
                'unit.floor.building.property',
            ])
            ->where('id', $validated['lease_id'])
            ->where('status', 'active')
            ->whereHas('unit.floor.building.property', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Prevent invalid dates against lease
        |--------------------------------------------------------------------------
        */

        $startDate = $lease->start_date;
        $endDate = $lease->end_date;

        if (
            $validated['issue_date'] < $startDate->format('Y-m-d') ||
            $validated['issue_date'] > $endDate->format('Y-m-d')
        ) {
            throw ValidationException::withMessages([
                'issue_date' =>
                'The invoice issue date must fall within the lease period.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Generate invoice and ledger entry
        |--------------------------------------------------------------------------
        */

        $invoice = DB::transaction(function () use ($validated, $lease) {

            $invoiceNumber = $this->generateInvoiceNumber();

            $amount = round((float) $validated['amount'], 2);

            $invoice = RentInvoice::create([
                'invoice_number' => $invoiceNumber,

                'lease_id' => $lease->id,

                'tenant_id' => $lease->tenant_id,

                'unit_id' => $lease->unit_id,

                'invoice_type' => $validated['invoice_type'],

                'description' => $validated['description'],

                'billing_period_start' =>
                $validated['billing_period_start'] ?? null,

                'billing_period_end' =>
                $validated['billing_period_end'] ?? null,

                'issue_date' => $validated['issue_date'],

                'due_date' => $validated['due_date'],

                'amount' => $amount,

                'paid_amount' => 0,

                'balance' => $amount,

                'status' => $validated['status'],

                'notes' => $validated['notes'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Only issued invoices affect the financial ledger.
            |--------------------------------------------------------------------------
            */

            if ($invoice->status === 'issued') {

                $previousBalance = RentLedgerEntries::where(
                    'lease_id',
                    $lease->id
                )
                    ->latest('id')
                    ->value('balance') ?? 0;

                $newBalance =
                    (float) $previousBalance +
                    $amount;

                RentLedgerEntries::create([
                    'tenant_id' => $lease->tenant_id,

                    'lease_id' => $lease->id,

                    'unit_id' => $lease->unit_id,

                    'rent_invoice_id' => $invoice->id,

                    'payment_id' => null,

                    'entry_type' =>
                    $validated['invoice_type'] === 'deposit'
                        ? 'deposit'
                        : 'invoice',

                    'entry_date' => $validated['issue_date'],

                    'description' => $validated['description'],

                    'debit' => $amount,

                    'credit' => 0,

                    'balance' => $newBalance,
                ]);
            }

            return $invoice;
        });

        return redirect()
            ->route(
                'property-management.invoices.show',
                $invoice
            )
            ->with(
                'success',
                "Invoice {$invoice->invoice_number} was created successfully."
            );
    }

    /**
     * Display invoice.
     */
    public function show(RentInvoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $invoice->load([
            'tenant',
            'lease',
            'unit.floor.building.property',
            'allocations.payment',
            'ledgerEntries',
        ]);

        return view(
            'property-management.invoices.show',
            compact('invoice')
        );
    }

    /**
     * Edit invoice.
     */
    public function edit(RentInvoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        /*
        |--------------------------------------------------------------------------
        | Paid invoices should never be edited.
        |--------------------------------------------------------------------------
        */

        if (
            in_array($invoice->status, [
                'paid',
                'partially_paid',
                'cancelled',
            ])
        ) {
            return redirect()
                ->route(
                    'property-management.invoices.show',
                    $invoice
                )
                ->with(
                    'error',
                    'This invoice cannot be edited because it has already been processed.'
                );
        }

        return view(
            'property-management.invoices.edit',
            compact('invoice')
        );
    }

    /**
     * Update invoice.
     */
    public function update(
        Request $request,
        RentInvoice $invoice
    ) {
        $this->authorizeInvoice($invoice);

        if (
            in_array($invoice->status, [
                'paid',
                'partially_paid',
                'cancelled',
            ])
        ) {
            return back()
                ->with(
                    'error',
                    'This invoice cannot be edited.'
                );
        }

        $validated = $request->validate([
            'description' => [
                'required',
                'string',
                'max:255',
            ],

            'billing_period_start' => [
                'nullable',
                'date',
            ],

            'billing_period_end' => [
                'nullable',
                'date',
                'after_or_equal:billing_period_start',
            ],

            'issue_date' => [
                'required',
                'date',
            ],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:issue_date',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $invoice,
            $validated
        ) {

            $oldAmount = (float) $invoice->amount;
            $newAmount = (float) $validated['amount'];
            $paidAmount = (float) $invoice->paid_amount;

            if ($newAmount < $paidAmount) {
                throw ValidationException::withMessages([
                    'amount' =>
                    'The invoice amount cannot be less than the amount already paid.'
                ]);
            }

            $invoice->update([
                'description' =>
                $validated['description'],

                'billing_period_start' =>
                $validated['billing_period_start'] ?? null,

                'billing_period_end' =>
                $validated['billing_period_end'] ?? null,

                'issue_date' =>
                $validated['issue_date'],

                'due_date' =>
                $validated['due_date'],

                'amount' =>
                $newAmount,

                'balance' =>
                $newAmount -
                    (float) $invoice->paid_amount,

                'notes' =>
                $validated['notes'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Adjust ledger if the invoice was already issued.
            |--------------------------------------------------------------------------
            */

            if ($invoice->status !== 'draft') {

                $difference =
                    $newAmount -
                    $oldAmount;

                if ($difference != 0) {

                    $latestLedger =
                        RentLedgerEntries::where(
                            'lease_id',
                            $invoice->lease_id
                        )
                        ->latest('id')
                        ->first();

                    $previousBalance =
                        $latestLedger
                        ? (float) $latestLedger->balance
                        : 0;

                    $newBalance =
                        $previousBalance +
                        $difference;

                    RentLedgerEntries::create([
                        'tenant_id' =>
                        $invoice->tenant_id,

                        'lease_id' =>
                        $invoice->lease_id,

                        'unit_id' =>
                        $invoice->unit_id,

                        'rent_invoice_id' =>
                        $invoice->id,

                        'entry_type' =>
                        'adjustment',

                        'entry_date' =>
                        now()->toDateString(),

                        'description' =>
                        'Invoice amount adjustment - ' .
                            $invoice->invoice_number,

                        'debit' =>
                        $difference > 0
                            ? $difference
                            : 0,

                        'credit' =>
                        $difference < 0
                            ? abs($difference)
                            : 0,

                        'balance' =>
                        max(0, $newBalance),
                    ]);
                }
            }
        });

        return redirect()
            ->route(
                'property-management.invoices.show',
                $invoice
            )
            ->with(
                'success',
                'Invoice updated successfully.'
            );
    }

    /**
     * Cancel invoice.
     */
    public function cancel(RentInvoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        if (
            $invoice->paid_amount > 0 ||
            in_array($invoice->status, [
                'paid',
                'partially_paid',
            ])
        ) {
            return back()->with(
                'error',
                'An invoice with payments cannot be cancelled.'
            );
        }

        DB::transaction(function () use ($invoice) {

            if ($invoice->status !== 'draft') {

                $latestLedger =
                    RentLedgerEntries::where(
                        'lease_id',
                        $invoice->lease_id
                    )
                    ->latest('id')
                    ->first();

                $previousBalance =
                    $latestLedger
                    ? (float) $latestLedger->balance
                    : 0;

                $amount = (float) $invoice->amount;

                RentLedgerEntries::create([
                    'tenant_id' =>
                    $invoice->tenant_id,

                    'lease_id' =>
                    $invoice->lease_id,

                    'unit_id' =>
                    $invoice->unit_id,

                    'rent_invoice_id' =>
                    $invoice->id,

                    'entry_type' =>
                    'adjustment',

                    'entry_date' =>
                    now()->toDateString(),

                    'description' =>
                    'Cancelled invoice - ' .
                        $invoice->invoice_number,

                    'debit' => 0,

                    'credit' => $amount,

                    'balance' =>
                    max(
                        0,
                        $previousBalance - $amount
                    ),
                ]);
            }

            $invoice->update([
                'status' => 'cancelled',
                'balance' => 0,
            ]);
        });

        return redirect()
            ->route(
                'property-management.invoices.index'
            )
            ->with(
                'success',
                "Invoice {$invoice->invoice_number} was cancelled."
            );
    }

    /**
     * Ensure invoice belongs to authenticated owner's portfolio.
     */
    protected function authorizeInvoice(
        RentInvoice $invoice
    ): void {
        $belongsToOwner = $invoice
            ->unit
            ?->floor
            ?->building
            ?->property
            ?->user_id === Auth::id();

        abort_unless(
            $belongsToOwner,
            403,
            'You are not authorized to access this invoice.'
        );
    }

    /**
     * Generate invoice number.
     */
    protected function generateInvoiceNumber(): string
    {
        do {

            $number =
                'TRI-' .
                now()->format('Ym') .
                '-' .
                strtoupper(str()->random(6));
        } while (
            RentInvoice::where(
                'invoice_number',
                $number
            )->exists()
        );

        return $number;
    }
}
