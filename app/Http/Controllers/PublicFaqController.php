<?php

namespace App\Http\Controllers;

use App\FaqFullAnswerSanitizer;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PublicFaqController extends Controller
{
    public function index(FaqFullAnswerSanitizer $sanitizer): View
    {
        $faqs = Faq::active()->ordered()->get();

        $faqs->each(function (Faq $faq) use ($sanitizer): void {
            $faq->setAttribute('has_full_answer', $sanitizer->sanitize($faq->full_answer) !== null);
        });

        return view('public.index', compact('faqs'));
    }

    public function show(Faq $faq, FaqFullAnswerSanitizer $sanitizer): View|Response
    {
        $fullAnswer = $faq->is_active ? $sanitizer->sanitize($faq->full_answer) : null;

        if ($fullAnswer === null) {
            return response()->view('public.not-found', [], 404);
        }

        return view('public.show', [
            'faq' => $faq,
            'fullAnswer' => $fullAnswer,
            'pageTitle' => $faq->question,
        ]);
    }
}
