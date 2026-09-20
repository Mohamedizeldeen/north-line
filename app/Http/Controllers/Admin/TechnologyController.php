<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    public function index()
    {
        $technologies = Technology::orderBy('sort_order')->orderBy('name')->paginate(20);

        return view('admin.technologies.index', compact('technologies'));
    }

    public function create()
    {
        return view('admin.technologies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|max:1024',
            'sort_order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('technologies', 'public');
        }

        Technology::create($validated);

        return redirect()->route('admin.technologies.index')->with('success', 'Technology created successfully.');
    }

    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit', compact('technology'));
    }

    public function update(Request $request, Technology $technology)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|max:1024',
            'sort_order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('technologies', 'public');
        }

        $technology->update($validated);

        return redirect()->route('admin.technologies.index')->with('success', 'Technology updated successfully.');
    }

    public function destroy(Technology $technology)
    {
        $technology->delete();

        return redirect()->route('admin.technologies.index')->with('success', 'Technology deleted successfully.');
    }
}
