@extends('layouts.public', ['pageTitle' => 'FAQ tidak ditemukan'])

@section('content')
    <div class="max-w-2xl">
        <h1 class="text-3xl font-bold leading-tight tracking-tight text-hospital-deep sm:text-[2.5rem]">FAQ tidak ditemukan</h1>
        <p class="mt-5 text-lg leading-relaxed text-ink">Informasi ini tidak tersedia. Silakan kembali ke daftar FAQ.</p>
        <a href="{{ route('public.index') }}" class="mt-8 inline-flex min-h-12 items-center rounded-xl bg-hospital px-5 py-3 font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
            Kembali ke FAQ
        </a>
    </div>
@endsection
