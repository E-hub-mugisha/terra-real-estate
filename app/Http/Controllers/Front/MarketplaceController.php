<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = ArchitecturalDesign::with('category')
            ->where('status', 'approved');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $designs = $query->orderBy('created_at', 'desc')->paginate(9);
        $categories = DesignCategory::all();

        return view('front.designs.index', compact('designs', 'categories'));
    }
    public function show($slug)
    {
        $design = ArchitecturalDesign::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        // Fetch related designs in the same category, excluding current
        $relatedDesigns = ArchitecturalDesign::where('category_id', $design->category_id)
            ->where('id', '!=', $design->id)
            ->where('status', 'approved')
            ->take(6)
            ->get();

        return view('front.designs.show', compact('design', 'relatedDesigns'));
    }
    // Purchase / download logic
    public function purchase($slug)
    {
        $design = ArchitecturalDesign::where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        if ($design->is_free) {
            // Increment download count
            $design->increment('download_count');

            // Return file download using response()->download instead of Storage::download
            if (!Storage::disk('public')->exists($design->design_file)) {
                abort(404, 'File not found');
            }
            $filePath = Storage::disk('public')->path($design->design_file);
            return response()->download($filePath, basename($filePath));
        }

        // If paid, show inquiry modal/page
        return view('front.designs.purchase', compact('design'));
    }

    // Send inquiry to the seller
    public function sendInquiry(Request $request)
    {
        $request->validate([
            'design_id' => 'required|exists:architectural_designs,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        $design = ArchitecturalDesign::findOrFail($request->design_id);

        // Example: send email to the seller
        Mail::to($design->user->email)->send(new \App\Mail\DesignInquiryMail($request->all(), $design));

        // SweetAlert success
        Alert::success('Inquiry Sent', 'Your inquiry has been successfully sent to the designer.');

        return back()->with('success', 'Your inquiry has been sent to the designer!');
    }
}
