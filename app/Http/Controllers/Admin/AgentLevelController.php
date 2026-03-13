<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentLevel;
use Illuminate\Http\Request;

class AgentLevelController extends Controller
{
    // List all levels
    public function index()
    {
        $levels = AgentLevel::orderBy('commission_rate')->get();

        return view('admin.agent-levels.index', compact('levels'));
    }

    // Show create form
    public function create()
    {
        $levelNames  = AgentLevel::levelNames();
        $badgeColors = AgentLevel::badgeColors();

        return view('admin.agent-levels.create', compact('levelNames', 'badgeColors'));
    }

    // Store new level
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level_name'      => 'required|in:bronze,silver,gold,elite',
            'label'           => 'required|string|max:255',
            'badge_emoji'     => 'nullable|string|max:10',
            'badge_color'     => 'required|string|max:20',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'requirements'    => 'nullable|string|max:1000',
        ]);

        // Check duplicate level name
        $exists = AgentLevel::where('level_name', $validated['level_name'])->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'level_name' => 'This level already exists. Each level can only be defined once.'
            ]);
        }

        AgentLevel::create($validated);

        return redirect()
            ->route('admin.agent-levels.index')
            ->with('success', 'Agent level created successfully.');
    }

    // Show single level
    public function show(AgentLevel $agentLevel)
    {
        $agentsCount = $agentLevel->agentStats()->count();

        return view('admin.agent-levels.show', compact('agentLevel', 'agentsCount'));
    }

    // Show edit form
    public function edit(AgentLevel $agentLevel)
    {
        $levelNames  = AgentLevel::levelNames();
        $badgeColors = AgentLevel::badgeColors();

        return view('admin.agent-levels.edit', compact('agentLevel', 'levelNames', 'badgeColors'));
    }

    // Update level
    public function update(Request $request, AgentLevel $agentLevel)
    {
        $validated = $request->validate([
            'level_name'      => 'required|in:bronze,silver,gold,elite',
            'label'           => 'required|string|max:255',
            'badge_emoji'     => 'nullable|string|max:10',
            'badge_color'     => 'required|string|max:20',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'requirements'    => 'nullable|string|max:1000',
        ]);

        // Check duplicate level name excluding current
        $exists = AgentLevel::where('level_name', $validated['level_name'])
            ->where('id', '!=', $agentLevel->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'level_name' => 'This level already exists. Each level can only be defined once.'
            ]);
        }

        $agentLevel->update($validated);

        return redirect()
            ->route('admin.agent-levels.index')
            ->with('success', 'Agent level updated successfully.');
    }

    // Delete level
    public function destroy(AgentLevel $agentLevel)
    {
        // Prevent deletion if agents are on this level
        if ($agentLevel->agentStats()->count() > 0) {
            return redirect()
                ->route('admin.agent-levels.index')
                ->with('error', 'Cannot delete this level — agents are currently assigned to it.');
        }

        $agentLevel->delete();

        return redirect()
            ->route('admin.agent-levels.index')
            ->with('success', 'Agent level deleted successfully.');
    }
}