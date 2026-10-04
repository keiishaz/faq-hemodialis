<?php

namespace App\Http\Controllers\Admin;

use App\FaqFullAnswerSanitizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');
        $status = in_array($status, ['all', 'active', 'inactive'], true) ? $status : 'all';

        $faqs = Faq::query()
            ->when($search !== '', fn ($query) => $query->where('question', 'like', '%'.addcslashes($search, '%_\\').'%'))
            ->when($status !== 'all', fn ($query) => $query->where('is_active', $status === 'active'))
            ->ordered()
            ->get();

        return view('admin.faqs.index', compact('faqs', 'search', 'status'));
    }

    public function create(): View
    {
        return view('admin.faqs.form', ['faq' => new Faq]);
    }

    public function store(FaqRequest $request, FaqFullAnswerSanitizer $sanitizer): RedirectResponse
    {
        $validated = $request->validated();

        Faq::query()->create([
            'question' => $validated['question'],
            'slug' => $this->uniqueSlug($validated['question']),
            'short_answer' => $validated['short_answer'],
            'full_answer' => $sanitizer->sanitize($validated['full_answer'] ?? null),
            'is_active' => (bool) $validated['is_active'],
            'sort_order' => (int) Faq::query()->max('sort_order') + 1,
        ]);

        return to_route('admin.faqs.index')->with('status', 'FAQ berhasil ditambahkan.');
    }

    public function show(Faq $faq, FaqFullAnswerSanitizer $sanitizer): View
    {
        return view('admin.faqs.show', [
            'faq' => $faq,
            'safeFullAnswer' => $sanitizer->sanitize($faq->full_answer),
        ]);
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(FaqRequest $request, Faq $faq, FaqFullAnswerSanitizer $sanitizer): RedirectResponse
    {
        $validated = $request->validated();

        $faq->update([
            'question' => $validated['question'],
            'short_answer' => $validated['short_answer'],
            'full_answer' => $sanitizer->sanitize($validated['full_answer'] ?? null),
            'is_active' => (bool) $validated['is_active'],
        ]);

        return to_route('admin.faqs.index')->with('status', 'FAQ berhasil diperbarui.');
    }

    public function toggle(Faq $faq): RedirectResponse
    {
        $faq->update(['is_active' => ! $faq->is_active]);

        return to_route('admin.faqs.index')->with('status', $faq->is_active ? 'FAQ diaktifkan.' : 'FAQ dinonaktifkan.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return to_route('admin.faqs.index')->with('status', 'FAQ berhasil dihapus permanen.');
    }

    private function uniqueSlug(string $question): string
    {
        $base = Str::limit(Str::slug($question), 220, '');
        $base = $base !== '' ? $base : 'faq';
        $slug = $base;
        $suffix = 2;

        while (Faq::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
