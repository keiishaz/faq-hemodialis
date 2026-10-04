@extends('layouts.public', ['pageTitle' => 'FAQ tidak ditemukan'])

@section('content')
    <div class="public-hero public-hero-not-found px-5 pb-20 pt-12 text-white sm:px-8 sm:pb-22 sm:pt-14">
        <div class="public-hero-copy mx-auto max-w-3xl text-center">
            <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-[#DDF5FF]">404</p>
            <h1 class="public-detail-title text-2xl font-semibold leading-tight tracking-tight sm:text-[2rem]">FAQ tidak ditemukan</h1>
            <p class="mx-auto mt-3 max-w-xl text-base leading-relaxed text-[#E8F8FF]">Informasi ini tidak tersedia. Silakan kembali ke daftar FAQ.</p>
        </div>
    </div>
    <div class="public-faq-container mx-auto max-w-4xl px-5 pb-16 sm:px-8">
        <div class="faq-search-shell relative -mt-8 rounded-2xl border border-[#D7E8F1] bg-white p-6 text-center sm:p-8">
            <a href="{{ route('public.index') }}" class="ui-press inline-flex min-h-11 items-center rounded-xl bg-hospital px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                Kembali ke FAQ
            </a>
        </div>
    </div>
@endsection
