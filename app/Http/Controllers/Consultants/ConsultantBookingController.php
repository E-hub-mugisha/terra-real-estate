<?php

namespace App\Http\Controllers\Consultants;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmedClient;
use App\Mail\BookingConfirmedConsultant;
use App\Models\Consultant;
use App\Models\ConsultantBooking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConsultantBookingController extends Controller
{

    private array $provinces = [
        'Kigali City',
        'Eastern Province',
        'Western Province',
        'Northern Province',
        'Southern Province',
    ];

    private array $districts = [
        'Kigali City'      => ['Gasabo', 'Kicukiro', 'Nyarugenge'],
        'Eastern Province' => ['Bugesera', 'Gatsibo', 'Kayonza', 'Kirehe', 'Ngoma', 'Nyagatare', 'Rwamagana'],
        'Western Province' => ['Karongi', 'Ngororero', 'Nyabihu', 'Nyamasheke', 'Rubavu', 'Rusizi', 'Rutsiro'],
        'Northern Province' => ['Burera', 'Gakenke', 'Gicumbi', 'Musanze', 'Rulindo'],
        'Southern Province' => ['Gisagara', 'Huye', 'Kamonyi', 'Muhanga', 'Nyamagabe', 'Nyanza', 'Nyaruguru', 'Ruhango'],
    ];

    // ─── Step 1: Service selection ────────────────────────────────────────────

    public function step1()
    {
        return view('consultant.step1-service', [
            'services' => Service::orderBy('title')->get(),
        ]);
    }

    public function step1Post(Request $request)
    {
        $request->validate(['service_id' => 'required|integer|exists:services,id']);

        $service = Service::findOrFail($request->service_id);

        session([
            'booking.service_id'    => $service->id,   // integer FK
            'booking.service_label' => $service->name,
        ]);

        return redirect()->route('consultant.step2');
    }

    // ─── Step 2: Province ─────────────────────────────────────────────────────

    public function step2()
    {
        $this->requireSession('booking.service_id');

        return view('consultant.step2-province', [
            'provinces'     => $this->provinces,
            'service_label' => session('booking.service_label'),
        ]);
    }

    public function step2Post(Request $request)
    {
        $request->validate(['province' => 'required|string']);
        abort_unless(in_array($request->province, $this->provinces), 422, 'Invalid province.');

        session(['booking.province' => $request->province]);
        return redirect()->route('consultant.step3');
    }

    // ─── Step 3: District ─────────────────────────────────────────────────────

    public function step3()
    {
        $this->requireSession('booking.province');
        $province = session('booking.province');

        return view('consultant.step3-district', [
            'province'  => $province,
            'districts' => $this->districts[$province] ?? [],
        ]);
    }

    public function step3Post(Request $request)
    {
        $province = session('booking.province');
        $request->validate(['district' => 'required|string']);
        abort_unless(in_array($request->district, $this->districts[$province] ?? []), 422, 'Invalid district.');

        session(['booking.district' => $request->district]);
        return redirect()->route('consultant.step4');
    }

    // ─── Step 4: Consultant listing ───────────────────────────────────────────

    public function step4()
    {
        $this->requireSession('booking.district');

        $consultants = Consultant::where('district', session('booking.district'))
            ->where('is_active', true)
            ->whereHas('services', fn($q) => $q->where('services.id', session('booking.service_id')))
            ->with('services')
            ->get();

        return view('consultant.step4-consultants', [
            'consultants'   => $consultants,
            'district'      => session('booking.district'),
            'service_label' => session('booking.service_label'),
        ]);
    }

    public function step4Post(Request $request)
    {
        $request->validate(['consultant_id' => 'required|exists:consultants,id']);

        $consultant = Consultant::findOrFail($request->consultant_id);
        session([
            'booking.consultant_id'   => $consultant->id,
            'booking.consultant_name' => $consultant->name,
        ]);

        return redirect()->route('consultant.step5');
    }

    // ─── Step 5: Appointment details ──────────────────────────────────────────

    public function step5()
    {
        $this->requireSession('booking.consultant_id');

        return view('consultant.step5-details', [
            'consultant'    => Consultant::findOrFail(session('booking.consultant_id')),
            'service_label' => session('booking.service_label'),
        ]);
    }

    public function step5Post(Request $request)
    {
        $request->validate([
            'client_name'      => 'required|string|max:100',
            'client_email'     => 'required|email',
            'client_phone'     => 'required|string|max:20',
            'appointment_date' => 'required|date|after_or_equal:today',
            'notes'            => 'nullable|string|max:1000',
        ]);

        session([
            'booking.client_name'      => $request->client_name,
            'booking.client_email'     => $request->client_email,
            'booking.client_phone'     => $request->client_phone,
            'booking.appointment_date' => $request->appointment_date,
            'booking.notes'            => $request->notes,
        ]);

        return redirect()->route('consultant.step6');
    }

    // ─── Step 6: Payment ──────────────────────────────────────────────────────

    public function step6()
    {
        $this->requireSession('booking.client_email');

        return view('consultant.step6-payment', [
            'consultant'    => Consultant::findOrFail(session('booking.consultant_id')),
            'service_label' => session('booking.service_label'),
            'district'      => session('booking.district'),
            'client_name'   => session('booking.client_name'),
            'client_phone'  => session('booking.client_phone'),
            'fee'           => 3000,
        ]);
    }

    public function step6Post(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:momo,airtel,card',
        ]);

        // Conditional rules per method
        $refRules = match ($request->payment_method) {
            'momo', 'airtel' => ['required', 'string', 'regex:/^\+?[0-9\s]{9,15}$/'],
            'card'           => ['required', 'string', 'digits:16'],
        };

        $request->validate([
            'payment_reference' => $refRules,
        ], [
            'payment_reference.required' => 'Please enter your ' . match ($request->payment_method) {
                'momo'   => 'MTN phone number',
                'airtel' => 'Airtel phone number',
                'card'   => 'card number',
            } . '.',
            'payment_reference.regex'  => 'Enter a valid phone number (e.g. +250 78X XXX XXX).',
            'payment_reference.digits' => 'Card number must be 16 digits.',
        ]);

        // ── In production: call Paypack / MoMo API here ──
        // $txn = PaypackService::charge($request->payment_reference, 3000);
        // if (!$txn->success) return back()->withErrors(['payment' => 'Payment failed. Try again.']);

        $booking = ConsultantBooking::create([
            'consultant_id'     => session('booking.consultant_id'),
            'service_id'        => session('booking.service_id'),
            'user_id'           => auth()->id(),
            'client_name'       => session('booking.client_name'),
            'client_email'      => session('booking.client_email'),
            'client_phone'      => session('booking.client_phone'),
            'province'          => session('booking.province'),
            'district'          => session('booking.district'),
            'appointment_date'  => session('booking.appointment_date'),
            'notes'             => session('booking.notes'),
            'fee'               => 3000,
            'payment_method'    => $request->payment_method,
            'payment_reference' => $request->payment_reference,
            'payment_status'    => 'paid',
            'status'            => 'pending',
        ]);

        session()->forget(array_map(
            fn($k) => "booking.$k",
            [
                'service_id',
                'service_label',
                'province',
                'district',
                'consultant_id',
                'consultant_name',
                'client_name',
                'client_email',
                'client_phone',
                'appointment_date',
                'notes'
            ]
        ));

        session(['booking.last_reference' => $booking->reference]);

        return redirect()->route('consultant.confirmed');
    }

    // ─── Step 7: Confirmation ─────────────────────────────────────────────────

    public function confirmed()
    {
        $ref = session('booking.last_reference');
        abort_unless($ref, 404);

        $booking = ConsultantBooking::with(['consultant', 'service'])
            ->where('reference', $ref)
            ->firstOrFail();

        return view('consultant.step7-confirmed', compact('booking'));
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    private function requireSession(string $key): void
    {
        if (! session()->has($key)) {
            abort(redirect()->route('consultant.step1'));
        }
    }
}
