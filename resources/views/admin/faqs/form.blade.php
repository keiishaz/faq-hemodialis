@extends('layouts.admin')

@php
    $editing = $faq->exists;
    $rawEditorHtml = old('full_answer', $faq->full_answer);
    $safeEditorHtml = app(\App\FaqFullAnswerSanitizer::class)->sanitize(is_string($rawEditorHtml) ? $rawEditorHtml : null);
@endphp

@section('title', $editing ? 'Edit FAQ' : 'Tambah FAQ')

@section('content')
    <div>
        <div>
            <h1 class="text-[1.625rem] font-semibold tracking-tight text-hospital-deep">{{ $editing ? 'Edit FAQ' : 'Tambah FAQ' }}</h1>
        </div>

        <form action="{{ $editing ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" method="POST" data-faq-form class="mt-5 rounded-xl border border-[#D6E5EE] bg-white p-4 sm:p-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div>
                <label for="question" class="mb-2 block text-sm font-semibold">Pertanyaan <span aria-hidden="true">*</span></label>
                <input id="question" name="question" type="text" maxlength="255" required value="{{ old('question', $faq->question) }}" aria-invalid="{{ $errors->has('question') ? 'true' : 'false' }}" @if ($errors->has('question')) aria-describedby="question-error" @endif class="min-h-11 w-full rounded-lg border border-[#9FB8C9] px-4 text-base outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
                @error('question') <p id="question-error" class="mt-2 text-sm font-medium text-[#A52D38]" role="alert">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label for="short_answer" class="mb-2 block text-sm font-semibold">Jawaban Singkat <span aria-hidden="true">*</span></label>
                <textarea id="short_answer" name="short_answer" rows="3" maxlength="2000" required aria-invalid="{{ $errors->has('short_answer') ? 'true' : 'false' }}" @if ($errors->has('short_answer')) aria-describedby="short-answer-help short-answer-error" @else aria-describedby="short-answer-help" @endif class="w-full rounded-lg border border-[#9FB8C9] px-4 py-3 text-sm leading-5 outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">{{ old('short_answer', $faq->short_answer) }}</textarea>
                <p id="short-answer-help" class="sr-only">Maksimal 2000 karakter.</p>
                @error('short_answer') <p id="short-answer-error" class="mt-2 text-sm font-medium text-[#A52D38]" role="alert">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <div class="mb-2 flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                    <label id="full-answer-label" class="text-sm font-semibold">Jawaban Lengkap <span class="font-normal text-[#52697B]">(opsional)</span></label>
                    <p id="full-answer-help" class="sr-only">Jawaban lengkap bersifat opsional.</p>
                </div>
                <div data-editor-toolbar aria-label="Format jawaban lengkap" class="flex flex-wrap gap-1 rounded-t-lg border border-[#9FB8C9] bg-paper p-1">
                    <button type="button" data-editor-command="bold" aria-label="Tebal" title="Tebal" class="flex size-10 items-center justify-center rounded-lg font-bold hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">B</button>
                    <button type="button" data-editor-command="italic" aria-label="Miring" title="Miring" class="flex size-10 items-center justify-center rounded-lg italic hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">I</button>
                    <button type="button" data-editor-command="insertUnorderedList" aria-label="Daftar poin" title="Daftar poin" class="flex size-10 items-center justify-center rounded-lg hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital"><span class="admin-icon admin-icon-list" aria-hidden="true"></span></button>
                    <button type="button" data-editor-command="insertOrderedList" aria-label="Daftar bernomor" title="Daftar bernomor" class="flex size-10 items-center justify-center rounded-lg hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital"><span class="admin-icon admin-icon-list-numbers" aria-hidden="true"></span></button>
                    <button type="button" data-editor-link aria-label="Tautan" title="Tautan" class="flex size-10 items-center justify-center rounded-lg hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital"><span class="admin-icon admin-icon-link" aria-hidden="true"></span></button>
                </div>
                <div data-faq-editor contenteditable="true" role="textbox" aria-multiline="true" aria-labelledby="full-answer-label" aria-describedby="full-answer-help" class="faq-editor min-h-44 rounded-b-lg border border-t-0 border-[#9FB8C9] bg-white px-4 py-3 text-base leading-relaxed outline-none focus-visible:ring-4 focus-visible:ring-sage">{!! $safeEditorHtml !!}</div>
                <textarea name="full_answer" data-editor-input hidden>{{ $safeEditorHtml }}</textarea>
                @error('full_answer') <p class="mt-2 text-sm font-medium text-[#A52D38]" role="alert">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 border-t border-[#D6E5EE] pt-5">
                <fieldset>
                    <legend class="text-sm font-semibold">Status <span aria-hidden="true">*</span></legend>
                    <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-[#52697B]">FAQ aktif ditampilkan pada halaman publik.</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach (['1' => 'Aktif', '0' => 'Nonaktif'] as $value => $label)
                                <label class="flex min-h-11 cursor-pointer items-center gap-2 rounded-lg border border-[#9FB8C9] px-4 text-sm font-medium has-[:checked]:border-hospital has-[:checked]:bg-sage">
                                    <input type="radio" name="is_active" value="{{ $value }}" @checked((string) old('is_active', $editing ? (int) $faq->is_active : 1) === (string) $value) class="accent-hospital">
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @error('is_active') <p class="mt-2 text-sm font-medium text-[#A52D38]" role="alert">{{ $message }}</p> @enderror
                </fieldset>
            </div>

            <div class="mt-5 flex flex-col-reverse gap-3 border-t border-[#D6E5EE] pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.faqs.index') }}" data-faq-cancel class="inline-flex min-h-11 items-center justify-center rounded-lg border border-[#9FB8C9] px-6 text-sm font-medium text-hospital-deep">Batal</a>
                <button type="submit" data-faq-submit class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg bg-hospital px-6 text-sm font-semibold text-white hover:bg-hospital-deep disabled:cursor-wait disabled:opacity-80"><span class="admin-icon admin-icon-check !size-4" aria-hidden="true"></span>Simpan FAQ</button>
            </div>
        </form>
    </div>
@endsection
