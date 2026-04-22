<?php

namespace App\Http\Controllers\Professionals;

use App\Http\Controllers\Controller;
use App\Mail\ProfessionalCredentialsMail;
use App\Models\Professional;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Notifications\StaffCredentialsNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeProfessionalController extends Controller
{
    // In your controller
    public function index()
    {
        $professionals = Professional::with(['professionalServices', 'serviceCategories'])
            ->where('is_verified', true) // optional
            ->latest()
            ->get();

        $professionTypes = Professional::select('profession')
            ->distinct()
            ->whereNotNull('profession')
            ->pluck('profession');

        return view('front.professionals.index', compact('professionals', 'professionTypes'));
    }

    public function show(Professional $professional)
    {
        $professional->load(['professionalServices', 'serviceCategories']);

        return view('front.professionals.show', compact('professional'));
    }

    public function professionalBecame()
    {
        return view('front.professionals.became');
    }

    public function create()
    {
        $serviceCategories = ServiceCategory::with('services')->where('slug', 'professionals-marketplace')->orderBy('name')->get();
        return view('front.professionals.register', compact('serviceCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        // ── Step → field map so we can jump to the right step on error ─
        $fieldStepMap = [
            // Step 0 — Personal Info
            'full_name'            => 0,
            'email'                => 0,
            'phone'                => 0,
            'whatsapp'             => 0,
            'office_location'      => 0,
            'languages'            => 0,

            // Step 1 — Professional Details
            'profession'           => 1,
            'license_number'       => 1,
            'bio'                  => 1,
            'website'              => 1,
            'portfolio_url'        => 1,
            'linkedin'             => 1,
            'profile_image'        => 1,
            'credentials_doc'      => 1,

            // Step 2 — Services
            'services'             => 2,
            'service_categories'   => 2,
        ];

        $validator = Validator::make($request->all(), [
            // ── Step 0
            'full_name'            => 'required|string|max:255',
            'email'                => 'required|email|unique:professionals,email',
            'phone'                => 'required|string|max:30',
            'whatsapp'             => 'nullable|string|max:30',
            'office_location'      => 'nullable|string|max:255',
            'languages'            => 'nullable|string|max:255',

            // ── Step 1
            'profession'           => 'required|string|max:100',
            'license_number'       => 'nullable|string|max:100',
            'bio'                  => 'required|string',
            'website'              => 'nullable|url',
            'portfolio_url'        => 'nullable|url',
            'linkedin'             => 'nullable|url',
            'profile_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'credentials_doc'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // ── Step 2
            'services'             => 'nullable|array',
            'services.*'           => 'exists:services,id',
            'service_categories'   => 'nullable|array',
        ]);

        if ($validator->fails()) {
            // Find the earliest step that contains a failing field
            $failingStep = 2;
            foreach (array_keys($validator->errors()->toArray()) as $field) {
                $base = explode('.', $field)[0]; // "services.0" → "services"
                $step = $fieldStepMap[$base] ?? 0;
                if ($step < $failingStep) {
                    $failingStep = $step;
                }
            }

            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('failingStep', $failingStep);
        }

        $data = $validator->validated();

        // ── Profile image upload ───────────────────────────────────────
        $data['profile_image'] = null;
        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $image    = $request->file('profile_image');
            $dir      = public_path('image/professionals');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $image->move($dir, $filename);
            $data['profile_image'] = 'image/professionals/' . $filename;
        }

        // ── Credentials document upload ────────────────────────────────
        $data['credentials_doc'] = null;
        if ($request->hasFile('credentials_doc') && $request->file('credentials_doc')->isValid()) {
            $doc      = $request->file('credentials_doc');
            $dir      = public_path('image/professionals/docs');
            $filename = time() . '_' . uniqid() . '.' . $doc->getClientOriginalExtension();
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $doc->move($dir, $filename);
            $data['credentials_doc'] = 'image/professionals/docs/' . $filename;
        }

        try {
            DB::beginTransaction();

            // Auto-generate a secure password for the new user
            $plainPassword = Str::password(length: 12, symbols: false);

            // 1) Create the User account
            $user = User::create([
                'name'              => $data['full_name'],
                'email'             => $data['email'],
                'password'          => Hash::make($plainPassword),
                'role'              => 'professional',
                'email_verified_at' => now(),
            ]);

            // 2) Create the Professional profile
            //    Note: full_name and email are stored here too because the model
            //    has those columns directly (not just via the user relationship).
            $professional = Professional::create([
                'user_id'         => $user->id,
                'full_name'       => $data['full_name'],
                'email'           => $data['email'],
                'phone'           => $data['phone'],
                'whatsapp'        => $data['whatsapp']        ?? null,
                'office_location' => $data['office_location'] ?? null,
                'languages'       => $data['languages']       ?? null,
                'profession'      => $data['profession'],
                'license_number'  => $data['license_number']  ?? null,
                'bio'             => $data['bio'],
                'website'         => $data['website']         ?? null,
                'portfolio_url'   => $data['portfolio_url']   ?? null,
                'linkedin'        => $data['linkedin']        ?? null,
                'profile_image'   => $data['profile_image'],
                'credentials_doc' => $data['credentials_doc'],
                'is_verified'     => false,
            ]);

            // 3) Sync pivot tables
            $professional->serviceCategories()
                ->sync($request->service_categories ?? []);
            $professional->professionalServices()->sync($request->services ?? []);

            DB::commit();

            // Log the new user in immediately
            Auth::login($user);
            $request->session()->regenerate();

            // Send login credentials by email (queued so it's non-blocking)
            Mail::to($user->email)->queue(
                new ProfessionalCredentialsMail($user, $plainPassword)
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            // Clean up any files that were already written before the DB failed
            foreach (['profile_image', 'credentials_doc'] as $field) {
                if (!empty($data[$field]) && file_exists(public_path($data[$field]))) {
                    unlink(public_path($data[$field]));
                }
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while creating the professional. Please try again.');
        }

        return redirect()->route(auth()->user()->redirectRoute())
            ->with('success', 'Your Consultant account has been created and is pending admin approval.');
    }
}
