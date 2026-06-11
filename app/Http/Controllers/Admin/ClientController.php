<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // ── LIST ────────────────────────────────────────────────
    public function index(Request $request)
    {
        $clients = Client::when(
            $request->search,
            fn($q) =>
            $q->where('full_name', 'like', "%{$request->search}%")
                ->orWhere('phone',   'like', "%{$request->search}%")
                ->orWhere('email',   'like', "%{$request->search}%")
        )
            ->when($request->type,     fn($q) => $q->where('client_type', $request->type))
            ->when($request->district, fn($q) => $q->where('district', $request->district))
            ->when(
                $request->status !== null && $request->status !== '',
                fn($q) => $q->where('is_active', (bool) $request->status)
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total'      => Client::count(),
            'owners'     => Client::where('client_type', 'owner')->count(),
            'agents'     => Client::where('client_type', 'agent')->count(),
            'developers' => Client::whereIn('client_type', ['developer', 'company'])->count(),
        ];

        $propertyCounts = Client::withCount(['houses', 'lands'])->get()->keyBy('id');
        foreach ($clients as $client) {
            $client->properties_count = ($propertyCounts[$client->id]->houses_count ?? 0) + ($propertyCounts[$client->id]->lands_count ?? 0);
        }

        return view('admin.clients.index', compact('clients', 'stats', 'propertyCounts'));
    }

    // ── SHOW ─────────────────────────────────────────────────
    public function show($id)
    {
        $client = Client::with(['createdBy', 'houses', 'lands'])
            ->findOrFail($id);

        $propertyCounts = [
            'houses' => $client->houses->count(),
            'lands'  => $client->lands->count(),
        ];
        $client->properties_count = $propertyCounts['houses'] + $propertyCounts['lands'];

        return view('admin.clients.show', compact('client', 'propertyCounts'));
    }

    // ── EDIT (AJAX JSON for modal on index page) ──────────────
    public function edit($id)
    {
        $client = Client::findOrFail($id);

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json(['client' => $client]);
        }

        // Fallback: redirect to show page with edit modal auto-opening
        return redirect()->route('admin.clients.show', $id);
    }

    // ── STORE ─────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone'        => 'required|string|max:20|unique:clients,phone',
            'email'        => 'nullable|email|max:255|unique:clients,email',
            'national_id'  => 'nullable|string|max:20|unique:clients,national_id',
            'province'     => 'nullable|string|max:100',
            'district'     => 'nullable|string|max:100',
            'sector'       => 'nullable|string|max:100',
            'client_type'  => 'required|in:owner,agent,developer,company',
            'company_name' => 'nullable|string|max:255',
            'notes'        => 'nullable|string|max:1000',
            'is_active'    => 'nullable|boolean',
        ]);

        $data['created_by'] = auth()->id();
        $data['is_active']  = $request->boolean('is_active', true);

        $client = Client::create($data);

        // AJAX response (for quick-add from property form)
        if ($request->expectsJson()) {
            return response()->json([
                'id'   => $client->id,
                'text' => "{$client->full_name} — {$client->phone}",
            ]);
        }

        return redirect()->route('admin.clients.index')
            ->with('success', "Client \"{$client->full_name}\" registered successfully.");
    }

    // ── UPDATE ────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $data = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone'        => "required|string|max:20|unique:clients,phone,{$client->id}",
            'email'        => "nullable|email|max:255|unique:clients,email,{$client->id}",
            'national_id'  => "nullable|string|max:20|unique:clients,national_id,{$client->id}",
            'province'     => 'nullable|string|max:100',
            'district'     => 'nullable|string|max:100',
            'sector'       => 'nullable|string|max:100',
            'client_type'  => 'required|in:owner,agent,developer,company',
            'company_name' => 'nullable|string|max:255',
            'notes'        => 'nullable|string|max:1000',
            'is_active'    => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $client->update($data);

        // If request came from the show page, redirect back there
        $referer = $request->headers->get('referer', '');
        if (str_contains($referer, "/admin/clients/{$id}")) {
            return redirect()->route('admin.clients.show', $id)
                ->with('success', 'Client updated successfully.');
        }

        return redirect()->route('admin.clients.index')
            ->with('success', "Client \"{$client->full_name}\" updated successfully.");
    }

    // ── DESTROY ───────────────────────────────────────────────
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $name   = $client->full_name;

        // Nullify client_id on properties so they're not lost
        $client->properties()->update(['client_id' => null]);

        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', "Client \"{$name}\" deleted. Properties have been unlinked.");
    }

    // ── SEARCH (AJAX for Tom Select on property form) ─────────
    // public function search(Request $request)
    // {
    //     $query = Client::where('is_active', true);

    //     if ($request->q) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('full_name', 'like', "%{$request->q}%")
    //                 ->orWhere('phone',   'like', "%{$request->q}%")
    //                 ->orWhere('email',   'like', "%{$request->q}%");
    //         });
    //     }

    //     // Allow fetching single by ID (for preview card)
    //     if ($request->id) {
    //         $query->where('id', $request->id);
    //     }

    //     $clients = $query->limit(20)->get(['id', 'full_name', 'phone', 'email', 'client_type']);

    //     return response()->json($clients->map(fn($c) => [
    //         'id'   => $c->id,
    //         'text' => "{$c->full_name} — {$c->phone}" . ($c->email ? " ({$c->email})" : ''),
    //         'type' => $c->client_type,
    //     ]));
    // }

    // ── QUICK-ADD (AJAX from property form Step 5) ────────────
    // public function quickAdd(Request $request)
    // {
    //     $data = $request->validate([
    //         'full_name'   => 'required|string|max:255',
    //         'phone'       => 'required|string|max:20|unique:clients,phone',
    //         'email'       => 'nullable|email|unique:clients,email',
    //         'client_type' => 'required|in:owner,agent,developer,company',
    //     ]);

    //     $data['created_by'] = auth()->id();
    //     $client = Client::create($data);

    //     return response()->json([
    //         'id'   => $client->id,
    //         'text' => "{$client->full_name} — {$client->phone}",
    //     ]);
    // }

    public function search(Request $request)
    {
        $query = Client::where('is_active', true);

        if ($request->filled('id')) {
            // Single lookup by ID (restore old('client_id') selection)
            $query->where('id', $request->id);
        } elseif ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('full_name', 'like', "%{$q}%")
                    ->orWhere('phone',    'like', "%{$q}%")
                    ->orWhere('email',    'like', "%{$q}%");
            });
        } else {
            // No query — return empty so Tom Select doesn't preload everything
            return response()->json([]);
        }

        return response()->json(
            $query->orderBy('full_name')
                ->limit(20)
                ->get([
                    'id',
                    'full_name',
                    'phone',
                    'email',
                    'client_type',
                    'company_name',
                    'district',
                    'national_id',
                ])
        );
    }

    /**
     * Quick-add from property form — returns full client object
     * so Tom Select / preview card gets all fields in one response.
     *
     * POST /admin/clients/quick-add
     */
    public function quickAdd(Request $request)
    {
        $data = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone'        => 'required|string|max:20|unique:clients,phone',
            'email'        => 'nullable|email|max:255|unique:clients,email',
            'client_type'  => 'required|in:owner,agent,developer,company',
            'company_name' => 'nullable|string|max:255',
            'national_id'  => 'nullable|string|max:20|unique:clients,national_id',
        ]);

        $data['created_by'] = auth()->id();
        $client = \App\Models\Client::create($data);

        // Return full object — same shape as search() results
        return response()->json(
            $client->only([
                'id',
                'full_name',
                'phone',
                'email',
                'client_type',
                'company_name',
                'district',
                'national_id',
            ]),
            201
        );
    }
}
