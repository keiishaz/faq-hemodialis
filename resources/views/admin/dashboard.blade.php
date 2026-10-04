@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-[1.625rem] font-semibold leading-tight tracking-tight text-hospital-deep">Dashboard</h1>
            <p class="mt-1 text-sm leading-relaxed text-[#52697B]">Ringkasan FAQ Hemodialisis.</p>
        </div>
        @if ($totalFaqs > 0)
            <a href="{{ route('admin.faqs.create') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-lg bg-hospital px-4 text-sm font-semibold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep"><span class="admin-icon admin-icon-plus" aria-hidden="true"></span>Tambah FAQ</a>
        @endif
    </div>

    <section aria-label="Ringkasan FAQ" class="mt-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-[#D6E5EE] bg-white p-5">
            <div class="flex items-center justify-between gap-3"><h2 class="text-sm font-medium text-[#52697B]">Total FAQ</h2><span class="flex size-8 items-center justify-center rounded-lg bg-[#E8F2FF] text-hospital" aria-hidden="true"><span class="admin-icon admin-icon-faq"></span></span></div>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-hospital-deep">{{ $totalFaqs }}</p>
            <p class="mt-1 text-sm text-[#52697B]">Pertanyaan tersimpan</p>
        </div>
        <div class="rounded-xl border border-[#D6E5EE] bg-white p-5">
            <div class="flex items-center justify-between gap-3"><h2 class="text-sm font-medium text-[#52697B]">FAQ Aktif</h2><span class="flex size-8 items-center justify-center rounded-lg bg-[#E7F6EE] text-[#176247]" aria-hidden="true"><span class="admin-icon admin-icon-active"></span></span></div>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-hospital-deep">{{ $activeFaqs }}</p>
            <p class="mt-1 text-sm text-[#52697B]">Tampil di halaman publik</p>
        </div>
        <div class="rounded-xl border border-[#D6E5EE] bg-white p-5">
            <div class="flex items-center justify-between gap-3"><h2 class="text-sm font-medium text-[#52697B]">FAQ Nonaktif</h2><span class="flex size-8 items-center justify-center rounded-lg bg-[#EBF0F4] text-[#667A8F]" aria-hidden="true"><span class="admin-icon admin-icon-hide"></span></span></div>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-hospital-deep">{{ $inactiveFaqs }}</p>
            <p class="mt-1 text-sm text-[#52697B]">Tidak tampil di publik</p>
        </div>
    </section>

    <section aria-labelledby="recent-faqs-title" class="mt-6 overflow-hidden rounded-xl border border-[#D6E5EE] bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 p-5">
            <div>
                <h2 id="recent-faqs-title" class="text-lg font-semibold text-hospital-deep">Terakhir diperbarui</h2>
            </div>
            @if ($totalFaqs > 0)
                <a href="{{ route('admin.faqs.index') }}" class="inline-flex min-h-10 items-center text-sm font-semibold text-hospital hover:underline focus-visible:outline-3 focus-visible:outline-hospital">Lihat semua FAQ</a>
            @endif
        </div>

        <div class="hidden grid-cols-[minmax(0,1fr)_130px_170px] gap-4 border-y border-[#D6E5EE] bg-paper px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.05em] text-[#52697B] lg:grid">
            <span>Pertanyaan</span><span>Status</span><span>Terakhir diperbarui</span>
        </div>
        <div>
        @forelse ($recentFaqs as $faq)
            <article class="grid gap-2 border-b border-[#D6E5EE] px-4 py-4 last:border-b-0 sm:px-5 lg:grid-cols-[minmax(0,1fr)_130px_170px] lg:items-center lg:gap-4">
                <div class="min-w-0">
                    <h3 class="text-sm font-medium leading-snug text-ink">{{ $faq->question }}</h3>
                </div>
                <span class="inline-flex w-fit items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $faq->is_active ? 'bg-[#E7F6EE] text-[#176247]' : 'bg-[#EBF0F4] text-[#52697B]' }}"><span aria-hidden="true" class="size-1.5 rounded-full bg-current"></span>{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                <span class="text-sm text-[#52697B]"><span class="lg:hidden">Diperbarui </span>{{ $faq->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
            </article>
        @empty
            <div class="p-6 sm:p-8">
                <h3 class="text-lg font-semibold text-ink">Belum ada FAQ.</h3>
                <p class="mt-2 text-[#52697B]">Tambahkan pertanyaan pertama untuk mulai mengelola informasi.</p>
                <a href="{{ route('admin.faqs.create') }}" class="mt-5 inline-flex min-h-11 items-center gap-2 rounded-lg bg-hospital px-5 font-semibold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep"><span class="admin-icon admin-icon-plus" aria-hidden="true"></span>Tambah FAQ</a>
            </div>
        @endforelse
        </div>
    </section>
@endsection
