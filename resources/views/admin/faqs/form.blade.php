@extends('layouts.admin')

@php
    $editing = $faq->exists;
    $rawEditorHtml = old('full_answer', $faq->full_answer);
    $safeEditorHtml = app(\App\FaqFullAnswerSanitizer::class)->sanitize(is_string($rawEditorHtml) ? $rawEditorHtml : null);
@endphp

@section('title', $editing ? 'Edit FAQ' : 'Tambah FAQ')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.faqs.index') }}" class="inline-flex min-h-11 items-center font-semibold text-hospital-deep underline focus-visible:outline-3 focus-visible:outline-hospital">Kembali ke daftar FAQ</a>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-hospital-deep sm:text-4xl">{{ $editing ? 'Edit FAQ' : 'Tambah FAQ' }}</h1>
        <p class="mt-2 text-base text-[#52615B]">Isi pertanyaan dan jawaban singkat. Jawaban lengkap dapat ditambahkan bila diperlukan.</p>

        <form action="{{ $editing ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" method="POST" data-faq-form class="mt-8 rounded-2xl border border-[#D9E4DD] bg-white p-5 sm:p-8">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div>
                <label for="question" class="mb-2 block font-semibold">Pertanyaan <span aria-hidden="true">*</span></label>
                <input id="question" name="question" type="text" maxlength="255" required value="{{ old('question', $faq->question) }}" aria-invalid="{{ $errors->has('question') ? 'true' : 'false' }}" @if ($errors->has('question')) aria-describedby="question-error" @endif class="min-h-12 w-full rounded-xl border border-[#627B6F] px-4 text-base outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
                @error('question') <p id="question-error" class="mt-2 text-sm font-medium text-[#9B3028]" role="alert">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6">
                <label for="short_answer" class="mb-2 block font-semibold">Jawaban Singkat <span aria-hidden="true">*</span></label>
                <textarea id="short_answer" name="short_answer" rows="5" maxlength="2000" required aria-invalid="{{ $errors->has('short_answer') ? 'true' : 'false' }}" @if ($errors->has('short_answer')) aria-describedby="short-answer-help short-answer-error" @else aria-describedby="short-answer-help" @endif class="w-full rounded-xl border border-[#627B6F] px-4 py-3 text-base leading-relaxed outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">{{ old('short_answer', $faq->short_answer) }}</textarea>
                <p id="short-answer-help" class="mt-2 text-sm text-[#52615B]">Teks biasa, maksimal 2000 karakter.</p>
                @error('short_answer') <p id="short-answer-error" class="mt-2 text-sm font-medium text-[#9B3028]" role="alert">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6">
                <label id="full-answer-label" class="mb-2 block font-semibold">Jawaban Lengkap <span class="font-normal text-[#52615B]">(opsional)</span></label>
                <div data-editor-toolbar aria-label="Format jawaban lengkap" class="flex flex-wrap gap-1 rounded-t-xl border border-[#627B6F] bg-paper p-2">
                    <button type="button" data-editor-command="bold" aria-label="Tebal" class="min-h-11 min-w-11 rounded-lg px-2 font-bold hover:bg-sage">B</button>
                    <button type="button" data-editor-command="italic" aria-label="Miring" class="min-h-11 min-w-11 rounded-lg px-2 italic hover:bg-sage">I</button>
                    <button type="button" data-editor-command="insertUnorderedList" class="min-h-11 rounded-lg px-3 text-sm font-semibold hover:bg-sage">Poin</button>
                    <button type="button" data-editor-command="insertOrderedList" class="min-h-11 rounded-lg px-3 text-sm font-semibold hover:bg-sage">Nomor</button>
                    <button type="button" data-editor-link class="min-h-11 rounded-lg px-3 text-sm font-semibold hover:bg-sage">Tautan</button>
                </div>
                <div data-faq-editor contenteditable="true" role="textbox" aria-multiline="true" aria-labelledby="full-answer-label" aria-describedby="full-answer-help" class="faq-editor min-h-48 rounded-b-xl border border-t-0 border-[#627B6F] bg-white px-4 py-3 text-base leading-relaxed outline-none focus-visible:ring-4 focus-visible:ring-sage">{!! $safeEditorHtml !!}</div>
                <textarea name="full_answer" data-editor-input hidden>{{ $safeEditorHtml }}</textarea>
                <p id="full-answer-help" class="mt-2 text-sm text-[#52615B]">Paragraf, tebal, miring, daftar, dan tautan aman. Tanpa gambar atau video.</p>
                @error('full_answer') <p class="mt-2 text-sm font-medium text-[#9B3028]" role="alert">{{ $message }}</p> @enderror
            </div>

            <fieldset class="mt-6">
                <legend class="font-semibold">Status <span aria-hidden="true">*</span></legend>
                <div class="mt-2 flex flex-wrap gap-3">
                    @foreach (['1' => 'Aktif', '0' => 'Nonaktif'] as $value => $label)
                        <label class="flex min-h-12 cursor-pointer items-center gap-2 rounded-xl border border-[#627B6F] px-4 font-medium has-[:checked]:border-hospital has-[:checked]:bg-sage">
                            <input type="radio" name="is_active" value="{{ $value }}" @checked((string) old('is_active', $editing ? (int) $faq->is_active : 1) === (string) $value) class="accent-hospital">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                @error('is_active') <p class="mt-2 text-sm font-medium text-[#9B3028]" role="alert">{{ $message }}</p> @enderror
            </fieldset>

            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-[#D9E4DD] pt-6 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.faqs.index') }}" data-faq-cancel class="inline-flex min-h-12 items-center justify-center rounded-xl border border-[#627B6F] px-6 font-semibold text-hospital-deep">Batal</a>
                <button type="submit" data-faq-submit class="min-h-12 rounded-xl bg-hospital px-6 font-bold text-white hover:bg-hospital-deep disabled:cursor-wait disabled:opacity-80">Simpan FAQ</button>
            </div>
        </form>
    </div>
@endsection
