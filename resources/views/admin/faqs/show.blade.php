@extends('layouts.admin')

@section('title', 'Pratinjau FAQ')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.faqs.index') }}" class="inline-flex min-h-11 items-center font-semibold text-hospital-deep underline">Kembali ke daftar FAQ</a>
        <div class="mt-5 flex flex-wrap items-center gap-3">
            <p class="text-sm font-bold uppercase tracking-[0.12em] text-hospital">Pratinjau admin</p>
            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $faq->is_active ? 'bg-sage text-hospital-deep' : 'bg-[#EEEDE8] text-[#52615B]' }}">{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        <h1 class="mt-4 text-3xl font-bold leading-tight tracking-tight text-hospital-deep sm:text-4xl">{{ $faq->question }}</h1>
        <div class="mt-8 rounded-2xl border border-[#D9E4DD] bg-white p-5 sm:p-8">
            <h2 class="text-sm font-bold uppercase tracking-[0.1em] text-hospital">Jawaban singkat</h2>
            <p class="mt-3 whitespace-pre-line text-base leading-relaxed">{{ $faq->short_answer }}</p>
            @if ($safeFullAnswer)
                <h2 class="mt-8 border-t border-[#D9E4DD] pt-7 text-sm font-bold uppercase tracking-[0.1em] text-hospital">Jawaban lengkap</h2>
                <div class="faq-content mt-3 leading-relaxed">{!! $safeFullAnswer !!}</div>
            @endif
        </div>
        <a href="{{ route('admin.faqs.edit', $faq) }}" class="mt-6 inline-flex min-h-12 items-center rounded-xl bg-hospital px-5 font-bold text-white hover:bg-hospital-deep">Edit FAQ</a>
    </div>
@endsection
