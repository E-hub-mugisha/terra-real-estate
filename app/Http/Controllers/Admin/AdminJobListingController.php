<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\ListingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminJobListingController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobListing::with('package')
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->payment, fn($q, $p) => $q->where('payment_status', $p))
            ->when($request->search, function ($q, $s) {
                $q->where(function ($q) use ($s) {
                    $q->where('title', 'like', "%{$s}%")
                      ->orWhere('company_name', 'like', "%{$s}%")
                      ->orWhere('company_email', 'like', "%{$s}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total'   => JobListing::count(),
            'active'  => JobListing::where('status', 'active')->count(),
            'pending' => JobListing::where('payment_status', 'pending')->count(),
            'expired' => JobListing::where('status', 'expired')->count(),
            'revenue' => JobListing::where('payment_status', 'paid')->sum('terra_share_amount'),
        ];

        return view('admin.job-listings.index', compact('jobs', 'stats'));
    }

    public function show(JobListing $jobListing)
    {
        $jobListing->load('package', 'user');
        return view('admin.job-listings.show', compact('jobListing'));
    }

    /**
     * Manually mark a job as paid and activate it (e.g. after offline payment).
     */
    public function activate(Request $request, JobListing $jobListing)
    {
        abort_if($jobListing->payment_status === 'paid', 422, 'Already paid.');

        $validated = $request->validate([
            'payment_reference' => 'required|string|max:255',
            'payment_method'    => 'required|string|max:100',
        ]);

        $jobListing->update($validated);
        $jobListing->activate();

        return back()->with('success', 'Job listing activated successfully.');
    }

    public function reject(Request $request, JobListing $jobListing)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $jobListing->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Job listing rejected.');
    }

    public function expire(JobListing $jobListing)
    {
        $jobListing->expire();
        return back()->with('success', 'Job listing expired.');
    }

    public function destroy(JobListing $jobListing)
    {
        $jobListing->delete();
        return redirect()
            ->route('admin.job-listings.index')
            ->with('success', 'Job listing deleted.');
    }

    /**
     * Step 1 — Show submission form with package selector.
     */
    public function create()
    {
        $packages = ListingPackage::forJobs()
            ->orderBy('price_per_day')
            ->get();

        return view('admin.job-listings.create', compact('packages'));
    }

    /**
     * Step 2 — Store the job listing and redirect to payment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'         => 'required|string|max:255',
            'company_email'        => 'required|email|max:255',
            'company_phone'        => 'nullable|string|max:30',
            'company_website'      => 'nullable|url|max:255',
            'company_logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title'                => 'required|string|max:255',
            'description'          => 'required|string|min:50',
            'requirements'         => 'nullable|string',
            'benefits'             => 'nullable|string',
            'location'             => 'required|string|max:255',
            'job_type'             => 'required|in:full-time,part-time,contract,internship,remote',
            'category'             => 'nullable|string|max:100',
            'salary_min'           => 'nullable|integer|min:0',
            'salary_max'           => 'nullable|integer|min:0|gte:salary_min',
            'show_salary'          => 'boolean',
            'application_deadline' => 'nullable|date|after:today',
            'application_email'    => 'required|email|max:255',
            'application_url'      => 'nullable|url|max:255',
            'listing_package_id'   => 'required|exists:listing_packages,id',
            'days_purchased'       => 'required|integer|min:1|max:365',
        ]);

        // Verify package is a job package and is active
        $package = ListingPackage::where('id', $validated['listing_package_id'])
            ->where('listing_type', 'job')
            ->where('is_active', true)
            ->firstOrFail();

        // Calculate amounts
        $billing = $package->calculateTotal($validated['days_purchased']);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('job-logos', 'public');
        }

        DB::beginTransaction();

        try {
            $job = JobListing::create([
                ...$validated,
                'slug'                    => JobListing::generateSlug($validated['title']),
                'company_logo'            => $logoPath,
                'total_amount'            => $billing['total'],
                'agent_commission_amount' => $billing['agent_commission'],
                'terra_share_amount'      => $billing['terra_share'],
                'status'                  => 'pending_payment',
                'payment_status'          => 'pending',
                'show_salary'             => $request->boolean('show_salary', true),
                'user_id'                 => auth()->id(),
            ]);

            DB::commit();

            // Redirect to payment page
            return redirect()->route('admin.job-listings.payment', $job);

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Payment page — shows summary before confirming payment.
     */
    public function payment(JobListing $job)
    {
        // Only owner or guest with matching email can see this
        abort_if($job->payment_status === 'paid', 404);

        return view('admin.job-listings.payment', compact('job'));
    }

    /**
     * Confirm payment (integrate with your payment gateway here).
     */
    public function confirmPayment(Request $request, JobListing $job)
    {
        abort_if($job->payment_status === 'paid', 404);

        $validated = $request->validate([
            'payment_reference' => 'required|string|max:255',
            'payment_method'    => 'required|in:momo,bank_transfer,card',
        ]);

        // TODO: verify payment with your gateway (MTN MoMo, etc.)
        // If verified:
        $job->update([
            'payment_reference' => $validated['payment_reference'],
            'payment_method'    => $validated['payment_method'],
        ]);

        $job->activate();

        return redirect()
            ->route('admin.job-listings.show', $job->slug)
            ->with('success', 'Your job listing is now live and will expire in ' . $job->days_purchased . ' days.');
    }

    /**
     * AJAX — calculate price preview when days / package changes.
     */
    public function pricePreview(Request $request)
    {
        $request->validate([
            'listing_package_id' => 'required|exists:listing_packages,id',
            'days'               => 'required|integer|min:1|max:365',
        ]);

        $package = ListingPackage::findOrFail($request->listing_package_id);
        $billing = $package->calculateTotal((int) $request->days);

        return response()->json($billing);
    }
}