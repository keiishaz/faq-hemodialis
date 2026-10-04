@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-3xl">
        <p class="mb-3 text-sm font-bold uppercase tracking-[0.12em] text-hospital">Panel pengelola</p>
        <h1 class="text-4xl font-bold leading-tight tracking-tight text-hospital-deep sm:text-5xl">Dashboard</h1>
        <p class="mt-4 text-lg leading-relaxed text-[#52615B]">Selamat datang, {{ auth()->user()->name }}.</p>

        <div class="mt-12 rounded-2xl border border-[#D9E4DD] bg-white p-6 sm:p-8">
            <h2 class="text-xl font-bold text-ink">Akses admin aktif</h2>
            <p class="mt-2 max-w-xl text-base leading-relaxed text-[#52615B]">Anda telah masuk ke panel pengelola FAQ Hemodialisis.</p>
        </div>
    </div>
@endsection
