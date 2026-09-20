<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = QuoteRequest::latest()->paginate(20);

        return view('admin.quotes.index', compact('quotes'));
    }

    public function show(QuoteRequest $quote)
    {
        if ($quote->status === 'unread') {
            $quote->update(['status' => 'read']);
        }

        return view('admin.quotes.show', compact('quote'));
    }

    public function destroy(QuoteRequest $quote)
    {
        $quote->delete();

        return redirect()->route('admin.quotes.index')->with('success', 'Quote request deleted successfully.');
    }
}
