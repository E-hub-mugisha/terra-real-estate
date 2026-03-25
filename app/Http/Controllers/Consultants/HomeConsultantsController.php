<?php

namespace App\Http\Controllers\Consultants;

use App\Http\Controllers\Controller;
use App\Mail\NewAppointmentMail;
use App\Models\Consultant;
use App\Models\ConsultantAppointment;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeConsultantsController extends Controller
{
    public function index()
    {
        $consultants = Consultant::where('is_active', true)->get();
        return view('front.consultants.index', compact('consultants'));
    }

    public function show(Consultant $consultant)
    {
        abort_if(!$consultant->is_active, 404);
        $reviews = $consultant->reviews()->latest()->get();
        $averageRating = round($consultant->reviews()->avg('rating'), 1);
        return view('front.consultants.show', compact('consultant', 'reviews', 'averageRating'));
    }

    public function consultantBecame()
    {
        return view('front.consultants.became');
    }

    public function create()
    {
        $serviceCategories = ServiceCategory::with('services')->where('slug', 'professionals-marketplace')->orderBy('name')->get();
        return view('front.consultants.register', compact('serviceCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'bio'      => 'nullable|string',
            'service_categories' => 'array',
            'title' => 'nullable|string|max:255',
            'services'              => 'nullable|array',
            'services.*'            => 'exists:services,id',
        ]);

        if ($photo = $request->file('photo')) {
            $destinationPath = 'image/consultant/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $photo->move($destinationPath, $filename);

            // Save relative path in DB
            $data['photo'] = "$filename";
        }

        // create user with default password and name from full_name field and email from email field
        $user = new \App\Models\User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($request->password); // default password, should be changed by the agent
        $user->role = 'consultant';
        $user->is_verified = false; // mark as verified by default
        $user->save();

        $consultant = Consultant::create([
            'user_id' => $user->id,
            'phone'   => $request->phone,
            'bio'     => $request->bio,
            'name'     => $request->name,
            'email'    => $request->email,
            'title'   => $request->title,
            'company' => $request->company,
            'photo'  => $filename,
            'is_active' => false
        ]);

        $consultant->serviceCategories()
            ->sync($request->service_categories ?? []);
        $consultant->services()->sync($request->services ?? []);
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route(auth()->user()->redirectRoute())
            ->with('success', 'Your Consultant account created and waiting for Admin pending approval.');
    }

    public function bookAppointment(Request $request, Consultant $consultant)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'date'    => 'required|date|after_or_equal:today',
            'time'    => 'required',
            'message' => 'nullable|string|max:1000',
        ]);

        // Store appointment
        $appointment = ConsultantAppointment::create([
            ...$validated,
            'consultant_id' => $consultant->id,
        ]);

        // Load the consultant relationship for the email
        $appointment->load('consultant');

        // Notify admin
        Mail::to(config('mail.admin_email'))
            ->send(new NewAppointmentMail($appointment));

        return back()->with('success', 'Your appointment has been booked! We will be in touch shortly.');
    }
}
