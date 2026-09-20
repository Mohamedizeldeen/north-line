<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\System;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function show(Request $request)
    {
        // Services populate the dropdown; ?service=<slug> preselects one.
        $services = System::inLocale()->published()->orderBy('sort_order')->get(['title', 'slug']);
        $selected = $request->query('service');

        return view('quote', compact('services', 'selected'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'service' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:5000',
        ]);

        QuoteRequest::create($validated);

        return redirect()->route('quote')->with('success', __('quote.success'));
    }
}
