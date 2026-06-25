<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    /* ─────────────────────────────────────────────────────────
     |  Rwanda geo data (shared across create / edit views)
     ───────────────────────────────────────────────────────── */
    private array $rwProvinces = [
        'Kigali City',
        'Northern Province',
        'Southern Province',
        'Eastern Province',
        'Western Province',
    ];
 
    private array $rwDistricts = [
        'Kigali City'       => ['Gasabo', 'Kicukiro', 'Nyarugenge'],
        'Northern Province' => ['Burera', 'Gakenke', 'Gicumbi', 'Musanze', 'Rulindo'],
        'Southern Province' => ['Gisagara', 'Huye', 'Kamonyi', 'Muhanga', 'Nyamagabe', 'Nyanza', 'Nyaruguru', 'Ruhango'],
        'Eastern Province'  => ['Bugesera', 'Gatsibo', 'Kayonza', 'Kirehe', 'Ngoma', 'Nyagatare', 'Rwamagana'],
        'Western Province'  => ['Karongi', 'Ngororero', 'Nyabihu', 'Nyamasheke', 'Rubavu', 'Rutsiro', 'Rusizi'],
    ];
 
    // Sectors per district (abbreviated — expand as needed)
    private array $rwSectors = [
        'Gasabo'      => ['Bumbogo','Gatsata','Gikomero','Gisozi','Jabana','Jali','Kacyiru','Kimihurura','Kimironko','Kinyinya','Ndera','Nduba','Remera','Rusororo','Rutunga'],
        'Kicukiro'    => ['Gahanga','Gatenga','Gikondo','Kagarama','Kanombe','Kicukiro','Kigarama','Masaka','Niboye','Nyarugunga'],
        'Nyarugenge'  => ['Gitega','Kanyinya','Kigali','Kimisagara','Mageragere','Muhima','Nyakabanda','Nyamirambo','Nyarugenge','Rwezamenyo'],
        'Musanze'     => ['Busogo','Cyuve','Gacaca','Gashaki','Gataraga','Kimonyi','Kinigi','Muhoza','Muko','Musanze','Nkotsi','Nyange','Remera','Rwaza','Shingiro'],
        'Rubavu'      => ['Bugeshi','Busasamana','Cyanzarwe','Gisenyi','Kanama','Kanzenze','Mudende','Nyamyumba','Nyundo','Rubavu','Rugerero'],
        'Huye'        => ['Gishamvu','Karama','Kigoma','Kinazi','Maraba','Mbazi','Mukura','Ngoma','Ruhashya','Rusatira','Rwaniro','Simbi','Tumba'],
        'Nyagatare'   => ['Gatunda','Karama','Karangazi','Katabagemu','Kibali','Matimba','Mimuli','Mukama','Musheri','Nyagatare','Orugamba','Rukomo','Rwempasha','Rwimiyaga','Tabagwe'],
        'Rwamagana'   => ['Fumbwe','Gahengeri','Gishari','Karenge','Kigabiro','Muhazi','Munyaga','Munyiginya','Musha','Muyumbu','Mwulire','Nyakariro','Nzige','Rubona'],
        'Karongi'     => ['Bwishyura','Gishyita','Gitesi','Mubuga','Murambi','Murundi','Mutuntu','Rubengera','Rugabano','Ruganda','Rwankuba','Twumba'],
        'Rusizi'      => ['Bugarama','Bweyeye','Giheke','Gihundwe','Gikundamvura','Gitambi','Kamembe','Muganza','Mururu','Nkungu','Nyakarenzo','Nzahaha','Rwimbogo'],
    ];

    public function index(Request $request)
    {
        $query = Agent::query();
 
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
 
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
 
        if ($province = $request->input('province')) {
            $query->where('province', $province);
        }
 
        if ($district = $request->input('district')) {
            $query->where('district', $district);
        }
 
        if ($sector = $request->input('sector')) {
            $query->where('sector', $sector);
        }
 
        $agents = $query->latest()->paginate(20)->withQueryString();
 
        return view('admin.users.agents.index', [
            'agents'      => $agents,
            'rwProvinces' => $this->rwProvinces,
            'rwDistricts' => $this->rwDistricts,
            'rwSectors'   => $this->rwSectors,
        ]);
    }

    public function create()
    {
        return view('admin.users.agents.create', [
            'rwProvinces' => $this->rwProvinces,
            'rwDistricts' => $this->rwDistricts,
            'rwSectors'   => $this->rwSectors,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:agents,email',
            'phone'            => 'required|string|max:30',
            'bio'              => 'nullable|string',
            'linkedin'         => 'nullable|url',
            'facebook'         => 'nullable|url',
            'instagram'        => 'nullable|url',
            'twitter'          => 'nullable|url',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'whatsapp'         => 'nullable|string|max:30',
            'office_location'  => 'nullable|string|max:255',
            'languages'        => 'nullable|string|max:255',
            'custom_password'  => 'nullable|string|min:8',
            'send_credentials' => 'nullable',
            'is_verified'      => 'nullable',
            'province'        => 'nullable|string|max:100',
            'district'        => 'nullable|string|max:100',
            'sector'          => 'nullable|string|max:100',
            'status'          => ['nullable', Rule::in(['Active', 'Suspended', 'Pending Approval'])],
        ]);

        if ($profile_image = $request->file('profile_image')) {
            $destinationPath = 'image/agents/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $profile_image->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $profile_image->move($destinationPath, $filename);

            // Save relative path in DB
            $data['profile_image'] = "$filename";
        }

        // Generate or use custom password
        $plainPassword = $request->boolean('auto_password') || !$request->filled('custom_password')
            ? \Illuminate\Support\Str::password(12)
            : $request->custom_password;

        // Create the user account
        $user = \App\Models\User::create([
            'name'              => $data['full_name'],
            'email'             => $data['email'],
            'password'          => \Illuminate\Support\Facades\Hash::make($plainPassword),
            'role'              => 'agent',
            'email_verified_at' => $request->boolean('is_verified') ? now() : null,
        ]);

        $data['user_id'] = $user->id;

        $agent = \App\Models\Agent::create($data);

        // Send credentials if toggled on
        if ($request->boolean('send_credentials')) {
            try {
                $user->notify(new \App\Notifications\StaffCredentialsNotification($plainPassword));
            } catch (\Exception $e) {
                return redirect()->route('admin.agents.index')
                    ->with('warning', "Agent created but credentials email failed. Password: {$plainPassword}");
            }
        }

        return redirect()->route('admin.agents.index')
            ->with('success', "✅ Agent {$user->name} created successfully. Credentials sent to {$user->email}.");
    }
    public function show(Request $request, Agent $agent)
    {
        $reviews = $agent->reviews()->latest()->get();
        $averageRating = round($agent->reviews()->avg('rating'), 1);

        $houses = collect();
        $lands = collect();

        if ($agent->user) {
            $houses = $agent->user->houses()
                ->where('is_approved', true)
                ->where('status', 'available')
                ->latest()
                ->get();

            $lands = $agent->user->lands()
                ->where('is_approved', true)
                ->where('status', 'available')
                ->latest()
                ->get();
        }

        $listings = $houses->merge($lands);

        $agent->recordView($request);

        $viewStats = [
            'total'       => $agent->views_count,
            'unique'      => $agent->unique_views_count,
            'today'       => $agent->viewsToday(),
            'this_week'   => $agent->viewsThisWeek(),
            'this_month'  => $agent->viewsThisMonth(),
            'daily_chart' => $agent->dailyViewsForPast(14),
        ];
        return view('admin.users.agents.profile', compact('agent', 'houses', 'lands', 'reviews', 'averageRating', 'listings', 'viewStats'));
    }

    public function approve(Request $request, Agent $agent)
    {
        $agent->update([
            'is_verified' => true,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Agent approved successfully.');
    }

    public function verifyAgent(Agent $agent)
    {
        $agent->update(['is_verified' => true, 'status'      => 'Active',]);

        return back()->with('success', "✅ {$agent->name} has been verified.");
    }

    public function reject(Request $request, Agent $agent)
    {
        $agent->update([
            'is_verified' => false,
            'status'      => 'suspended',
        ]);

        return back()->with('success', 'Agent rejected successfully.');
    }
    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:agents,email,' . $agent->id,
            'phone'            => 'required|string|max:30',
            'bio'              => 'nullable|string',
            'linkedin'         => 'nullable|url',
            'facebook'         => 'nullable|url',
            'instagram'        => 'nullable|url',
            'twitter'          => 'nullable|url',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'whatsapp'         => 'nullable|string|max:30',
            'office_location'  => 'nullable|string|max:255',
            'languages'        => 'nullable|string|max:255',
            'province'        => 'nullable|string|max:100',
            'district'        => 'nullable|string|max:100',
            'sector'          => 'nullable|string|max:100',
            'status'          => ['nullable', Rule::in(['Active', 'Suspended', 'Pending Approval'])],
        ]);

        if ($profile_image = $request->file('profile_image')) {
            $destinationPath = 'image/agents/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $profile_image->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $profile_image->move($destinationPath, $filename);

            // Save relative path in DB
            $data['profile_image'] = "$filename";
        }

        // Sync name + email to the linked user account
        if ($agent->user) {
            $agent->user->update([
                'name'  => $data['full_name'],
                'email' => $data['email'],
            ]);
        }

        $agent->update($data);

        return back()->with('success', '✅ Agent updated successfully.');
    }

    public function resetPassword(Agent $agent)
    {
        $password = \Illuminate\Support\Str::password(12);
        $agent->user->update(['password' => \Illuminate\Support\Facades\Hash::make($password)]);

        try {
            $agent->user->notify(new \App\Notifications\StaffCredentialsNotification($password));
        } catch (\Exception $e) {
            return back()->with('error', 'Password reset but email failed.');
        }

        return back()->with('success', "Password reset. New credentials sent to {$agent->email}.");
    }
    public function edit(Agent $agent)
    {
        $agent->load('user');

        return view('admin.users.agents.edit',[
            'agent'       => $agent,
            'rwProvinces' => $this->rwProvinces,
            'rwDistricts' => $this->rwDistricts,
            'rwSectors'   => $this->rwSectors,
        ]);
    }

    public function destroy(Agent $agent)
    {
        // Delete related user first
        if ($agent->user) {
            $agent->user->delete();
        }

        // Then delete agent
        $agent->delete();

        return redirect()->route('admin.users.agents.index')->with('success', 'Agent and user deleted successfully');
    }

    public function updateStatus(Request $request, Agent $agent)
    {
        $request->validate([
            'status' => ['required', Rule::in(['Active', 'Suspended', 'Pending Approval'])],
        ]);
 
        $agent->update(['status' => $request->input('status')]);
 
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status'  => $agent->status,
                'message' => "Status updated to \"{$agent->status}\".",
            ]);
        }
 
        return back()->with('success', "Agent status updated to \"{$agent->status}\".");
    }
}
