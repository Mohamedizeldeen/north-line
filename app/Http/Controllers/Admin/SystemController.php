<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SystemController extends Controller
{
    public function index()
    {
        $systems = System::orderBy('sort_order')->latest()->paginate(15);

        return view('admin.systems.index', compact('systems'));
    }

    public function create()
    {
        return view('admin.systems.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'demo_url' => 'nullable|url|max:255',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('systems', 'public');
        }

        System::create($validated);

        return redirect()->route('admin.systems.index')->with('success', 'System created successfully.');
    }

    public function edit(System $system)
    {
        return view('admin.systems.edit', compact('system'));
    }

    public function update(Request $request, System $system)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'demo_url' => 'nullable|url|max:255',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('systems', 'public');
        }

        $system->update($validated);

        return redirect()->route('admin.systems.index')->with('success', 'System updated successfully.');
    }

    public function destroy(System $system)
    {
        $system->delete();

        return redirect()->route('admin.systems.index')->with('success', 'System deleted successfully.');
    }
}
