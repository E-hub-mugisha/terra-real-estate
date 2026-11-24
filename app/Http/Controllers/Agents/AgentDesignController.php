<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AgentDesignController extends Controller
{
    /**
     * List designs
     */
    public function index(Request $request)
    {
        $mine = fn () => ArchitecturalDesign::managedBy(Auth::user());

        $query = $mine()->with(['category'])
            ->when($request->search,   fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->status,   fn($q) => $q->where('status', $request->status))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->featured, fn($q) => $q->where('featured', true))
            ->when($request->free,     fn($q) => $q->where('is_free', true))
            ->when($request->sort === 'price_asc',  fn($q) => $q->orderBy('price'))
            ->when($request->sort === 'price_desc', fn($q) => $q->orderByDesc('price'))
            ->when($request->sort === 'title',      fn($q) => $q->orderBy('title'))
            ->when($request->sort === 'oldest',     fn($q) => $q->oldest())
            ->latest();

        $stats = [
            'total'    => $mine()->count(),
            'approved' => $mine()->where('status', 'approved')->count(),
            'pending'  => $mine()->where('status', 'pending')->count(),
            'rejected' => $mine()->where('status', 'rejected')->count(),
            'free'     => $mine()->where('is_free', true)->count(),
            'featured' => $mine()->where('featured', true)->count(),
        ];

        return view('agents.architecturals.index', [
            'designs'    => $query->paginate(15)->withQueryString(),
            'categories' => DesignCategory::orderBy('name')->get(),
            'stats'      => $stats,
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = DesignCategory::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('agents.architecturals.create', compact('categories', 'users'));
    }

    /**
     * Store design
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'user_id'       => 'nullable|exists:users,id',
            'category_id'   => 'required|exists:design_categories,id',
            'description'   => 'nullable|string',
            'design_file'   => 'required|mimes:pdf,zip,dwg|max:20480',
            'preview_image' => 'nullable|image|max:4096',
            'price'         => 'nullable|numeric|min:0',
        ]);

        $slug = Str::slug($request->title) . '-' . time();

        // Upload files
        $designFilePath = $request->file('design_file')
            ->store('architectural_designs/files', 'public');

        $previewPath = null;
        if ($request->hasFile('preview_image')) {
            $previewPath = $request->file('preview_image')
                ->store('architectural_designs/previews', 'public');
        }

        $design = ArchitecturalDesign::create([
            'title'          => $request->title,
            'slug'           => $slug,
            // Agents always own what they upload; the Terra team approves it.
            'user_id'        => Auth::id(),
            'agent_id'       => Auth::user()->agent?->id,
            'owner_user_id'  => Auth::user()->isOwner() ? Auth::id() : null,
            'partner_id'     => Auth::user()->isPartner() ? Auth::id() : null,
            'added_by'       => Auth::id(),
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'design_file'    => $designFilePath,
            'preview_image'  => $previewPath,
            'price'          => $request->price ?? 0,
            'is_free'        => $request->price == 0,
            'status'         => 'pending',
            'is_approved'    => false,
            'featured'       => false,
        ]);

        return redirect()->route('plans.select', [
            'type' => 'design',
            'id' => $design->id
        ])->with('success', 'Architectural design created successfully.');
    }

    public function show(ArchitecturalDesign $architecturalDesign)
    {
        $this->authorizeOwner($architecturalDesign);

        return view('agents.architecturals.show', compact('architecturalDesign'));
    }
    /**
     * Show edit form
     */
    public function edit(ArchitecturalDesign $architecturalDesign)
    {
        $this->authorizeOwner($architecturalDesign);
        $categories = DesignCategory::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view(
            'agents.architecturals.edit',
            compact('architecturalDesign', 'categories', 'users')
        );
    }

    /**
     * Update design
     */
    public function update(Request $request, ArchitecturalDesign $architecturalDesign)
    {
        $design = $architecturalDesign;
        $this->authorizeOwner($design);

        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:design_categories,id',
            'description'   => 'nullable|string',
            'design_file'   => 'nullable|mimes:pdf,zip,dwg|max:20480',
            'preview_image' => 'nullable|image|max:4096',
            'price'         => 'nullable|numeric|min:0',
        ]);

        $data = $request->only(['title', 'category_id', 'description', 'price']);
        $data['is_free'] = ($request->price ?? 0) == 0;

        // Keep the public URL stable unless the title actually changed.
        if ($design->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }
        // Edits to an approved design go back to the Terra team for review.
        if ($design->status === 'approved' && ($design->title !== $request->title || (float) $design->price !== (float) ($request->price ?? 0) || $request->hasFile('design_file'))) {
            $data['status'] = 'pending';
            $data['is_approved'] = false;
        }

        if ($request->hasFile('design_file')) {
            Storage::disk('public')->delete($design->design_file);
            $data['design_file'] = $request->file('design_file')
                ->store('architectural_designs/files', 'public');
        }

        if ($request->hasFile('preview_image')) {
            if ($design->preview_image) {
                Storage::disk('public')->delete($design->preview_image);
            }
            $data['preview_image'] = $request->file('preview_image')
                ->store('architectural_designs/previews', 'public');
        }

        $design->update($data);

        return redirect()
            ->route('agent.designs.show', $design->id)
            ->with('success', ($data['status'] ?? null) === 'pending' ? 'Design updated and sent for review.' : 'Design updated.');
    }

    /**
     * Delete design
     */
    public function destroy(ArchitecturalDesign $architecturalDesign)
    {
        $this->authorizeOwner($architecturalDesign);

        Storage::disk('public')->delete(array_filter([
            $architecturalDesign->design_file,
            $architecturalDesign->preview_image,
        ]));

        $architecturalDesign->delete();

        return redirect()
            ->route('agent.designs.index')
            ->with('success', 'Architectural design deleted.');
    }

    private function authorizeOwner(ArchitecturalDesign $design): void
    {
        abort_unless($design->isManagedBy(Auth::user()), 403, 'You can only manage your own designs.');
    }
}
