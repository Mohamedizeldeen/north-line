<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->paginate(30);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $this->validated($request);

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'question_ar' => 'nullable|string|max:500',
            'question_en' => 'nullable|string|max:500',
            'answer_ar' => 'nullable|string|max:2000',
            'answer_en' => 'nullable|string|max:2000',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ]);

        $validated += [
            'question_ar' => null, 'question_en' => null,
            'answer_ar' => null, 'answer_en' => null,
        ];

        if (! $validated['question_ar'] && ! $validated['question_en']) {
            throw ValidationException::withMessages(['question_ar' => 'Provide a question in at least one language.']);
        }

        if ($validated['question_ar'] && ! $validated['answer_ar']) {
            throw ValidationException::withMessages(['answer_ar' => 'Arabic answer is required when the Arabic question is set.']);
        }

        if ($validated['question_en'] && ! $validated['answer_en']) {
            throw ValidationException::withMessages(['answer_en' => 'English answer is required when the English question is set.']);
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}
