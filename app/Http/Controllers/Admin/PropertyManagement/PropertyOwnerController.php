<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\PropertyOwner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyOwnerController extends Controller
{
    public function index()
    {
        $owners = PropertyOwner::with('user')
            ->withCount('properties')
            ->latest()
            ->paginate(15);

        return view(
            'admin.property-management.owners.index',
            compact('owners')
        );
    }

    public function create()
    {
        $users = User::query()
            ->whereNotIn(
                'id',
                PropertyOwner::query()->pluck('user_id')->toArray(),
                'and'
            )
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $owner = new PropertyOwner();

        return view(
            'admin.property-management.owners.create',
            compact('users', 'owner')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
                Rule::unique('property_owners', 'user_id'),
            ],
            'owner_type' => [
                'required',
                Rule::in(['individual', 'company']),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'national_id' => [
                'nullable',
                'string',
                'max:100',
                'unique:property_owners,national_id',
            ],
            'company_name' => [
                'nullable',
                'string',
                'max:255',
                'required_if:owner_type,company',
            ],
            'tin' => [
                'nullable',
                'string',
                'max:100',
                'unique:property_owners,tin',
            ],
            'address' => ['nullable', 'string', 'max:2000'],
            'verification_status' => [
                'required',
                Rule::in(['pending', 'verified', 'rejected']),
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $owner = PropertyOwner::create($validated);

        return redirect()
            ->route('admin.property-management.owners.show', $owner)
            ->with('success', 'Property owner created successfully.');
    }

    public function show(PropertyOwner $owner)
    {
        $owner->load('user')
            ->loadCount('properties');

        $properties = $owner->properties()
            ->latest()
            ->paginate(10);

        return view(
            'admin.property-management.owners.show',
            compact('owner', 'properties')
        );
    }

    public function edit(PropertyOwner $owner)
    {
        $owner->load('user');

        return view(
            'admin.property-management.owners.edit',
            compact('owner')
        );
    }

    public function update(Request $request, PropertyOwner $owner)
    {
        $validated = $request->validate([
            'owner_type' => [
                'required',
                Rule::in(['individual', 'company']),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'national_id' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('property_owners', 'national_id')
                    ->ignore($owner->id),
            ],
            'company_name' => [
                'nullable',
                'string',
                'max:255',
                'required_if:owner_type,company',
            ],
            'tin' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('property_owners', 'tin')
                    ->ignore($owner->id),
            ],
            'address' => ['nullable', 'string', 'max:2000'],
            'verification_status' => [
                'required',
                Rule::in(['pending', 'verified', 'rejected']),
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $owner->update($validated);

        return redirect()
            ->route('admin.property-management.owners.show', $owner)
            ->with('success', 'Property owner updated successfully.');
    }
}
