<?php

namespace App\Http\Controllers;

use App\Models\System;

class SystemController extends Controller
{
    public function index()
    {
        $systems = System::availableIn()->published()->orderBy('sort_order')->get();

        return view('systems.index', compact('systems'));
    }

    public function show(System $system)
    {
        if (! $system->is_published) {
            abort(404);
        }

        return view('systems.show', compact('system'));
    }
}
