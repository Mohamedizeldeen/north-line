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
        $faqs = Faq::orderBy('locale')->orderBy('sort_order')->paginate(30);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePair($request);
        $shared = $this->sharedAttributes($request, $validated);

        $this->savePair($validated, $shared, null, null);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq)
    {
        [$ar, $en] = $this->pair($faq);

        return view('admin.faqs.edit', compact('faq', 'ar', 'en'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $this->validatePair($request);
        $shared = $this->sharedAttributes($request, $validated);

        [$ar, $en] = $this->pair($faq);

        $this->savePair($validated, $shared, $ar, $en);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    /** The Arabic and English rows of the same FAQ, if they exist. */
    private function pair(Faq $faq): array
    {
        $sibling = $faq->translation($faq->locale === 'ar' ? 'en' : 'ar');

        return [
            $faq->locale === 'ar' ? $faq : $sibling,
            $faq->locale === 'en' ? $faq : $sibling,
        ];
    }

    private function validatePair(Request $request): array
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

        return $validated;
    }

    /** Fields that are not language-specific: one value shared by both rows. */
    private function sharedAttributes(Request $request, array $validated): array
    {
        return [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];
    }

    private function savePair(array $validated, array $shared, ?Faq $ar, ?Faq $en): void
    {
        if ($validated['question_ar']) {
            $attrs = array_merge($shared, [
                'question' => $validated['question_ar'],
                'answer' => $validated['answer_ar'],
            ]);

            $ar = $ar ? tap($ar)->update($attrs) : Faq::create(array_merge($attrs, ['locale' => 'ar']));
        }

        if ($validated['question_en']) {
            $attrs = array_merge($shared, [
                'question' => $validated['question_en'],
                'answer' => $validated['answer_en'],
            ]);

            $en = $en ? tap($en)->update($attrs) : Faq::create(array_merge($attrs, ['locale' => 'en']));
        }

        if ($ar && $en) {
            $ar->pairWith($en);
        }
    }
}
