<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Land;
use App\Models\House;
use App\Models\ArchitecturalDesign;
use App\Models\ListingPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // ── Map slug → model class ─────────────────────────────────────────────
    private const PAYABLE_MAP = [
        'land'                 => Land::class,
        'house'                => House::class,
        'architectural-design' => ArchitecturalDesign::class,
    ];

    // ── 1. Show payment page ───────────────────────────────────────────────
    /**
     * GET /payment/{reference}
     */
    public function show(string $reference)
    {
        $payment = ListingPayment::with('payable')
            ->where('reference', $reference)
            ->firstOrFail();

        if ($payment->isCompleted()) {
            return redirect()->route('payment.success', $reference)
                ->with('info', 'This payment is already completed.');
        }

        return view('payments.show', compact('payment'));
    }

    // ── 2. Initiate (submit phone & method) ────────────────────────────────
    /**
     * POST /payment/{reference}/initiate
     */
    public function initiate(Request $request, string $reference)
    {
        $payment = ListingPayment::where('reference', $reference)
            ->firstOrFail();

        $request->validate([
            'payment_method' => 'required|in:momo,card,bank_transfer',
            'phone_number'   => 'required_if:payment_method,momo|nullable|string|max:20',
        ]);

        // Save chosen method & phone
        $payment->update([
            'payment_method' => $request->payment_method,
            'phone_number'   => $request->phone_number,
            'status'         => 'processing',
        ]);

        // ── Call your gateway here ─────────────────────────────────────────
        // Example: MoMo MTN Rwanda push
        // $result = MoMoService::requestToPay($payment);
        //
        // For now we store the gateway reference and redirect to success.
        // Replace the block below with your real gateway SDK call.

        try {
            // Simulate gateway reference for now
            $gatewayRef = 'MOMO-' . strtoupper(uniqid());
            $payment->update(['gateway_reference' => $gatewayRef]);

            // ── If gateway is async (push), redirect user to pending page ──
            // ── If gateway is sync (card redirect), redirect to gateway URL ──

            return redirect()->route('payment.pending', $reference)
                ->with('success', 'Payment request sent. Please approve on your phone.');
        } catch (\Exception $e) {
            Log::error('Payment initiation failed', [
                'reference' => $reference,
                'error'     => $e->getMessage(),
            ]);

            $payment->markFailed($e->getMessage());

            return back()->with('error', 'Payment could not be initiated. Please try again.');
        }
    }

    // ── 3. Pending page (polling) ──────────────────────────────────────────
    /**
     * GET /payment/{reference}/pending
     */
    public function pending(string $reference)
    {
        $payment = ListingPayment::with('payable')
            ->where('reference', $reference)
            ->firstOrFail();

        return view('payments.pending', compact('payment'));
    }

    // ── 4. Poll status (AJAX) ──────────────────────────────────────────────
    /**
     * GET /payment/{reference}/status  (JSON)
     */
    public function status(string $reference)
    {
        $payment = ListingPayment::where('reference', $reference)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'status'      => $payment->status,
            'redirectUrl' => $payment->isCompleted()
                ? route('payment.success', $reference)
                : null,
        ]);
    }

    // ── 5. Gateway webhook / callback ─────────────────────────────────────
    /**
     * POST /payment/callback  (called by MoMo / Flutterwave / etc.)
     * No auth middleware on this route.
     */
    public function callback(Request $request)
    {
        Log::info('Payment callback received', $request->all());

        // ── Verify the caller ──────────────────────────────────────────────
        // The gateway must send the shared secret (PAYMENT_CALLBACK_TOKEN in .env).
        // Without a configured token every callback is rejected, so nobody can
        // mark a payment as paid by posting to this public URL.
        $expected = (string) config('services.payments.callback_token');
        $given = (string) ($request->header('X-Terra-Callback-Token') ?? $request->input('token'));
        if ($expected === '' || !hash_equals($expected, $given)) {
            Log::warning('Rejected payment callback with invalid token', ['ip' => $request->ip()]);

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $reference     = $request->input('externalId') ?? $request->input('reference');
        $transactionId = $request->input('financialTransactionId') ?? $request->input('transaction_id');
        $status        = $request->input('status'); // SUCCESS | FAILED

        $payment = ListingPayment::where('reference', $reference)->first();

        if (! $payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if ($status === 'SUCCESSFUL' || $status === 'completed') {
            $payment->markCompleted($transactionId, json_encode($request->all()));

            // ── Post-payment business logic ────────────────────────────────
            $this->onPaymentSuccess($payment);
        } else {
            $payment->markFailed(
                $request->input('reason', 'Gateway declined'),
                json_encode($request->all())
            );
        }

        return response()->json(['message' => 'Webhook processed']);
    }

    // ── 6. Success page ───────────────────────────────────────────────────
    /**
     * GET /payment/{reference}/success
     */
    public function success(string $reference)
    {
        $payment = ListingPayment::with('payable')
            ->where('reference', $reference)
            ->firstOrFail();

        $typeMap = [
            \App\Models\House::class               => 'houses',
            \App\Models\Land::class                => 'lands',
            \App\Models\ArchitecturalDesign::class => 'architectural-designs',
        ];

        $role        = $payment->user->role;                      // ✅ defined
        $payableType = $payment->payable_type;                  // ✅ defined
        $payableId   = $payment->payable_id;                    // ✅ defined
        $segment     = $typeMap[$payableType] ?? null;

        $viewRoute = null;

        if ($segment && in_array($role, ['admin', 'agent'])) {
            $routeName = "{$role}.properties.{$segment}.show";

            if (\Illuminate\Support\Facades\Route::has($routeName)) {
                $viewRoute = route($routeName, $payableId);
            } else {
                \Illuminate\Support\Facades\Log::warning("Redirect route not found: {$routeName}");
            }
        }

        return view('payments.success', compact('payment', 'viewRoute'));
    }

    // ── Private: post-payment actions ──────────────────────────────────────
    private function onPaymentSuccess(ListingPayment $payment): void
    {
        // Start the package: listing period, ad rotation, spotlight + commissions.
        app(\App\Services\Marketplace\PromotionService::class)->activateFromPayment($payment);
    }

    /**
     * POST /payment/{reference}/confirm
     * The payer submits the MoMo transaction ID. The payment then waits for an
     * admin to verify it (Admin → Payments); the package starts on verification.
     */
    public function confirm(Request $request, string $reference)
    {
        $payment = ListingPayment::where('reference', $reference)->firstOrFail();
        abort_unless($payment->user_id === $request->user()->id || $request->user()->isStaff(), 403);

        if ($payment->isCompleted()) {
            return redirect()->route('payment.success', $payment->reference);
        }

        $request->validate([
            'transaction_id' => 'required|string|max:100',
            'note'           => 'nullable|string|max:255',
        ]);

        $payment->markAwaitingVerification($request->transaction_id, $request->note);

        return redirect()
            ->route('payment.success', $payment->reference)
            ->with('success', 'Thanks! We received your transaction ID. Your package starts as soon as the Terra team verifies the payment.');
    }
}
