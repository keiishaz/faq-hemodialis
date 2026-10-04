@extends('layouts.public', ['pageTitle' => 'FAQ tidak ditemukan'])

@section('content')
    <div class="public-hero px-5 pb-25 pt-18 text-white sm:px-8 sm:pb-29 sm:pt-22">
        <div class="mx-auto max-w-3xl text-center">
            <p class="mb-4 text-sm font-bold tracking-[0.14em] text-[#DDF5FF]">404</p>
            <h1 class="text-3xl font-bold leading-tight tracking-tight sm:text-[2.5rem]">FAQ tidak ditemukan</h1>
            <p class="mx-auto mt-5 max-w-xl text-lg leading-relaxed text-[#E8F8FF]">Informasi ini tidak tersedia. Silakan kembali ke daftar FAQ.</p>
        </div>
    </div>
    <div class="mx-auto max-w-5xl px-5 pb-20 sm:px-8">
        <div class="faq-search-shell relative -mt-9 rounded-2xl border border-[#D7E8F1] bg-white p-7 text-center sm:p-10">
            <a href="{{ route('public.index') }}" class="ui-press inline-flex min-h-12 items-center rounded-xl bg-hospital px-5 py-3 font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                Kembali ke FAQ
            </a>
        </div>
    </div>
@endsection
