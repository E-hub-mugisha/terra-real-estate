<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FloorController extends Controller
{
    public function index(Request $request)
    {
        $floors = Floor::with('building.managedProperty')
            ->withCount('units')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhereHas('building', function ($buildingQuery) use ($search) {
                            $buildingQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('building_code', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('building_id'), function ($query) use ($request) {
                $query->where('building_id', $request->input('building_id'));
            })
            ->orderBy('building_id')
            ->orderBy('floor_number')
            ->paginate(15);

        $buildings = Building::with('managedProperty')
            ->orderBy('name')
            ->get();

        return view(
            'admin.property-management.floors.index',
            compact('floors', 'buildings')
        );
    }

    public function create()
    {
        $buildings = Building::with('managedProperty')
            ->orderBy('name')
            ->get();

        $floor = new Floor();

        return view(
            'admin.property-management.floors.create',
            compact('floor', 'buildings')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateFloor($request);

        $floor = Floor::create($validated);

        return redirect()
            ->route('admin.property-management.floors.show', $floor)
            ->with('success', 'Floor created successfully.');
    }

    public function show(Floor $floor)
    {
        $floor->load([
            'building.managedProperty.owner.user',
            'units',
        ]);

        return view(
            'admin.property-management.floors.show',
            compact('floor')
        );
    }

    public function edit(Floor $floor)
    {
        $buildings = Building::with('managedProperty')
            ->orderBy('name')
            ->get();

        return view(
            'admin.property-management.floors.edit',
            compact('floor', 'buildings')
        );
    }

    public function update(Request $request, Floor $floor)
    {
        if (
            $floor->units()->exists() &&
            (int) $request->input('building_id') !== (int) $floor->building_id
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'building_id' => 'You cannot move a floor to another building while it contains units.',
                ]);
        }

        $validated = $this->validateFloor($request, $floor);

        $floor->update($validated);

        return redirect()
            ->route('admin.property-management.floors.show', $floor)
            ->with('success', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        if ($floor->units()->exists()) {
            return redirect()
                ->route('admin.property-management.floors.show', $floor)
                ->with(
                    'error',
                    'This floor cannot be deleted because it contains units.'
                );
        }

        $floor->delete();

        return redirect()
            ->route('admin.property-management.floors.index')
            ->with('success', 'Floor deleted successfully.');
    }

    private function validateFloor(
        Request $request,
        ?Floor $floor = null
    ): array {
        return $request->validate([
            'building_id' => [
                'required',
                'integer',
                Rule::exists('buildings', 'id'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'floor_number' => [
                'required',
                'integer',
                'min:-5',
                'max:300',
                Rule::unique('floors', 'floor_number')
                    ->where('building_id', $request->input('building_id'))
                    ->ignore($floor?->id),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);
    }
}