@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.12em] text-hospital">Panel pengelola</p>
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-hospital-deep sm:text-4xl">Dashboard</h1>
            <p class="mt-2 text-base leading-relaxed text-[#52615B]">Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan FAQ Hemodialisis.</p>
        </div>
        @if ($totalFaqs > 0)
            <a href="{{ route('admin.faqs.create') }}" class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-xl bg-hospital px-5 font-bold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep">Tambah FAQ</a>
        @endif
    </div>

    <section aria-label="Ringkasan FAQ" class="mt-8 overflow-hidden rounded-2xl border border-[#D9E4DD] bg-white sm:grid sm:grid-cols-3">
        <div class="border-b border-[#D9E4DD] p-5 sm:border-b-0 sm:border-r sm:p-6">
            <h2 class="text-sm font-semibold text-[#52615B]">Total FAQ</h2>
            <p class="mt-3 text-4xl font-bold tracking-tight text-hospital-deep">{{ $totalFaqs }}</p>
        </div>
        <div class="border-b border-[#D9E4DD] p-5 sm:border-b-0 sm:border-r sm:p-6">
            <h2 class="text-sm font-semibold text-[#52615B]">FAQ Aktif</h2>
            <p class="mt-3 text-4xl font-bold tracking-tight text-hospital-deep">{{ $activeFaqs }}</p>
        </div>
        <div class="p-5 sm:p-6">
            <h2 class="text-sm font-semibold text-[#52615B]">FAQ Nonaktif</h2>
            <p class="mt-3 text-4xl font-bold tracking-tight text-hospital-deep">{{ $inactiveFaqs }}</p>
        </div>
    </section>

    <section aria-labelledby="recent-faqs-title" class="mt-10">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 id="recent-faqs-title" class="text-xl font-bold text-hospital-deep sm:text-2xl">Terakhir diperbarui</h2>
                <p class="mt-1 text-sm text-[#52615B]">Hingga lima FAQ dengan perubahan terbaru.</p>
            </div>
            @if ($totalFaqs > 0)
                <a href="{{ route('admin.faqs.index') }}" class="inline-flex min-h-11 items-center font-semibold text-hospital-deep underline focus-visible:outline-3 focus-visible:outline-hospital">Lihat semua FAQ</a>
            @endif
        </div>

        <div class="mt-4 overflow-hidden rounded-2xl border border-[#D9E4DD] bg-white">
        @forelse ($recentFaqs as $faq)
            <article class="flex flex-col gap-4 border-b border-[#D9E4DD] p-5 last:border-b-0 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div class="min-w-0">
                    <h3 class="font-bold leading-snug text-ink">{{ $faq->question }}</h3>
                    <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-[#52615B]">
                        <span class="font-semibold {{ $faq->is_active ? 'text-hospital-deep' : '' }}">{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        <span>Diperbarui {{ $faq->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.faqs.edit', $faq) }}" class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg border border-hospital px-4 text-sm font-semibold text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">Edit</a>
            </article>
        @empty
            <div class="p-6 sm:p-8">
                <h3 class="text-lg font-bold text-ink">Belum ada FAQ.</h3>
                <p class="mt-2 text-[#52615B]">Tambahkan pertanyaan pertama untuk mulai mengelola informasi.</p>
                <a href="{{ route('admin.faqs.create') }}" class="mt-5 inline-flex min-h-12 items-center rounded-xl bg-hospital px-5 font-bold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep">Tambah FAQ</a>
            </div>
        @endforelse
        </div>
    </section>
@endsection
