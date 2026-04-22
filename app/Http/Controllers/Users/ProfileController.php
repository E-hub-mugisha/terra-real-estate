<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultantPortfolio;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // ── Fields that count toward completeness ──────────────
    private const COMPLETENESS_FIELDS = [
        'name', 'title', 'email', 'phone', 'bio',
        'photo', 'registration_number', 'province',
        'district', 'availability',
    ];
 
    public function edit()
    {
        $consultant = Auth::user()->consultant()->with(['services', 'serviceCategories'])->firstOrFail();
        $portfolio  = $consultant->portfolioItems()->orderByDesc('id')->get();
        $allServices = Service::orderBy('title')->get();
        $completeness = $this->calcCompleteness($consultant, $portfolio);
 
        return view('users.consultant.profile.edit', compact('consultant', 'portfolio', 'allServices', 'completeness'));
    }
 
    public function update(Request $request)
    {
        $consultant = Auth::user()->consultant()->firstOrFail();
 
        $request->validate([
            'name'         => 'required|string|max:120',
            'title'        => 'required|string|max:120',
            'email'        => 'nullable|email|max:180',
            'phone'        => 'nullable|string|max:30',
            'bio'          => 'required|string|max:2000',
            'photo'        => 'nullable|image|max:2048',
            'cv'           => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'province'     => 'nullable|string|max:60',
            'district'     => 'nullable|string|max:60',
            'availability' => 'nullable|in:available,limited,unavailable',
            'services'     => 'nullable|array',
            'services.*'   => 'integer|exists:services,id',
 
            // Portfolio additions
            'portfolio_images.*'   => 'nullable|image|max:3072',
            'portfolio_titles.*'   => 'nullable|string|max:120',
            'portfolio_locations.*'=> 'nullable|string|max:120',
            'portfolio_years.*'    => 'nullable|integer|min:2000|max:' . date('Y'),
 
            // Portfolio removals
            'remove_portfolio'     => 'nullable|array',
            'remove_portfolio.*'   => 'integer',
        ]);
 
        // ── Photo ──────────────────────────────────────────
        if ($request->remove_photo == '1') {
            $this->deleteFile($consultant->photo);
            $consultant->photo = null;
        } elseif ($request->hasFile('photo')) {
            $this->deleteFile($consultant->photo);
            $consultant->photo = $this->moveFile($request->file('photo'), 'consultants');
        }
 
        // ── CV ─────────────────────────────────────────────
        if ($request->hasFile('cv')) {
            $this->deleteFile($consultant->cv);
            $consultant->cv = $this->moveFile($request->file('cv'), 'consultants/cv');
        }
 
        // ── Core fields ────────────────────────────────────
        $consultant->fill($request->only([
            'name', 'title', 'email', 'phone', 'bio',
            'province', 'district', 'availability',
        ]));
        $consultant->save();
 
        // ── Services pivot ─────────────────────────────────
        $consultant->services()->sync($request->input('services', []));
 
        // ── Portfolio removals ─────────────────────────────
        if ($request->filled('remove_portfolio')) {
            $items = ConsultantPortfolio::where('consultant_id', $consultant->id)
                ->whereIn('id', $request->remove_portfolio)
                ->get();
            foreach ($items as $item) {
                $this->deleteFile($item->image);
                $item->delete();
            }
        }
 
        // ── Portfolio additions ────────────────────────────
        if ($request->hasFile('portfolio_images')) {
            foreach ($request->file('portfolio_images') as $i => $imgFile) {
                $title    = $request->portfolio_titles[$i]    ?? null;
                $location = $request->portfolio_locations[$i] ?? null;
                $year     = $request->portfolio_years[$i]     ?? null;
                if (!$title) continue;
 
                ConsultantPortfolio::create([
                    'consultant_id' => $consultant->id,
                    'title'         => $title,
                    'location'      => $location,
                    'year'          => $year,
                    'image'         => $this->moveFile($imgFile, 'portfolio'),
                ]);
            }
        } elseif ($request->filled('portfolio_titles.0')) {
            // Image-less portfolio item
            $title    = $request->portfolio_titles[0];
            $location = $request->portfolio_locations[0] ?? null;
            $year     = $request->portfolio_years[0]     ?? null;
            ConsultantPortfolio::create([
                'consultant_id' => $consultant->id,
                'title'         => $title,
                'location'      => $location,
                'year'          => $year,
            ]);
        }
 
        return redirect()->route('consultant.profile.edit')
            ->with('success', 'Your profile has been updated successfully.');
    }
 
    // ── Verification change request ────────────────────────
    public function verifyRequest(Request $request)
    {
        $request->validate(['field' => 'required|in:licence,discipline']);
 
        $consultant = Auth::user()->consultant()->firstOrFail();
 
        // Mark verification as pending and notify admin
        $consultant->is_verified = false;
        $consultant->save();
 
        // TODO: dispatch a VerificationChangeRequested notification/event
        // event(new \App\Events\VerificationChangeRequested($consultant, $request->field));
 
        return response()->json(['status' => 'submitted']);
    }
 
    // ── Helpers ────────────────────────────────────────────
 
    private function calcCompleteness($consultant, $portfolio): int
    {
        $filled = 0;
        $total  = count(self::COMPLETENESS_FIELDS) + 2; // +services +portfolio
 
        foreach (self::COMPLETENESS_FIELDS as $field) {
            if (!empty($consultant->$field)) $filled++;
        }
 
        if ($consultant->services->isNotEmpty()) $filled++;
        if ($portfolio->isNotEmpty())            $filled++;
 
        return (int) round(($filled / $total) * 100);
    }
 
    /**
     * Move an uploaded file to public/image/{folder}/ (consistent with Terra's move() convention).
     */
    private function moveFile(\Illuminate\Http\UploadedFile $file, string $folder): string
    {
        $filename  = time() . '_' . $file->getClientOriginalName();
        $dest      = public_path("image/{$folder}");
        if (!is_dir($dest)) mkdir($dest, 0755, true);
        $file->move($dest, $filename);
        return "{$folder}/{$filename}";
    }
 
    private function deleteFile(?string $path): void
    {
        if ($path && file_exists(public_path("image/{$path}"))) {
            @unlink(public_path("image/{$path}"));
        }
    }
}
