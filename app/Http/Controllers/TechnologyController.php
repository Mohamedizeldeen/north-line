<?php

namespace App\Http\Controllers;

use App\Models\Technology;

class TechnologyController extends Controller
{
    public function index()
    {
        $technologies = Technology::orderBy('sort_order')->orderBy('name')->get()->groupBy('category');
        return view('technologies.index', compact('technologies'));
    }
}
