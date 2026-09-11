<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::published()->orderBy('sort_order')->get();

        return view('clients.index', compact('clients'));
    }
}
