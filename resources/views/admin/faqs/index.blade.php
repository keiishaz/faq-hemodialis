@extends('layouts.admin')

@section('title', 'Daftar FAQ')

@section('content')
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.12em] text-hospital">Kelola informasi</p>
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-hospital-deep sm:text-4xl">Daftar FAQ</h1>
            <p class="mt-2 text-base text-[#52615B]">Tulis jawaban yang jelas, lalu atur status sebelum ditampilkan kepada pengunjung.</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-xl bg-hospital px-5 font-bold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep">Tambah FAQ</a>
    </div>

    @if (session('status'))
        <div class="mt-7 rounded-xl border border-[#A9D1BE] bg-sage px-4 py-3 font-medium text-hospital-deep" role="status">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mt-7 rounded-xl border border-[#C68C80] bg-[#FFF4F0] px-4 py-3 font-medium text-[#9B3028]" role="alert">{{ session('error') }}</div>
    @endif

    <div class="mt-8 rounded-2xl border border-[#D9E4DD] bg-white p-4 sm:p-5">
        <form action="{{ route('admin.faqs.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
            @if ($status !== 'all') <input type="hidden" name="status" value="{{ $status }}"> @endif
            <label for="faq-search" class="sr-only">Cari pertanyaan FAQ</label>
            <input id="faq-search" name="search" type="search" value="{{ $search }}" placeholder="Cari pertanyaan FAQ" class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 text-base outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
            <button type="submit" class="min-h-12 rounded-xl border border-hospital px-5 font-semibold text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">Cari</button>
        </form>
        <nav aria-label="Filter status FAQ" class="mt-5 flex flex-wrap gap-2">
            @foreach (['all' => 'Semua', 'active' => 'Aktif', 'inactive' => 'Nonaktif'] as $value => $label)
                <a href="{{ route('admin.faqs.index', array_filter(['status' => $value === 'all' ? null : $value, 'search' => $search === '' ? null : $search])) }}" @if ($status === $value) aria-current="page" @endif class="inline-flex min-h-11 items-center rounded-lg px-4 text-sm font-semibold focus-visible:outline-3 focus-visible:outline-hospital {{ $status === $value ? 'bg-sage text-hospital-deep' : 'text-[#52615B] hover:bg-paper' }}">{{ $label }}</a>
            @endforeach
        </nav>
    </div>

    <div class="mt-6 flex flex-wrap items-center justify-between gap-2 text-sm">
        <p id="reorder-help" class="text-[#52615B]">
            @if ($reorderEnabled)
                Geser tombol Pindah, atau fokuskan lalu tekan panah atas atau bawah untuk mengubah urutan.
            @elseif ($status !== 'all' || $search !== '')
                Pengurutan tersedia pada tab Semua saat pencarian kosong.
            @else
                Tambahkan FAQ lain untuk mengatur urutan.
            @endif
        </p>
        <div class="flex items-center gap-3">
            <p data-reorder-feedback role="status" aria-live="polite" class="font-semibold text-hospital-deep"></p>
            <button type="button" data-reorder-reload hidden class="min-h-12 font-semibold text-hospital-deep underline">Muat ulang daftar</button>
        </div>
    </div>

    <div data-reorder-list @if ($reorderEnabled) data-reorder-url="{{ route('admin.faqs.reorder') }}" data-reorder-snapshot="{{ $orderSnapshot }}" data-reorder-token="{{ csrf_token() }}" data-login-url="{{ route('admin.login') }}" @endif class="mt-3 space-y-3">
        @forelse ($faqs as $faq)
            <article data-sort-item data-sort-id="{{ $faq->id }}" class="faq-sort-item rounded-2xl border border-[#D9E4DD] bg-white p-5 sm:p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex min-w-0 items-start gap-4">
                        <button type="button" data-sort-handle @disabled(! $reorderEnabled) aria-label="Pindahkan FAQ: {{ $faq->question }}" aria-describedby="reorder-help" class="min-h-12 shrink-0 touch-none rounded-lg border border-[#627B6F] px-3 text-sm font-semibold text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital disabled:cursor-not-allowed disabled:opacity-50">Pindah</button>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $faq->is_active ? 'bg-sage text-hospital-deep' : 'bg-[#EEEDE8] text-[#52615B]' }}">{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                <span class="text-sm text-[#52615B]">Diperbarui {{ $faq->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                            <h2 class="mt-3 text-lg font-bold leading-snug text-ink">{{ $faq->question }}</h2>
                            <p class="mt-2 line-clamp-2 whitespace-pre-line text-sm leading-relaxed text-[#52615B]">{{ $faq->short_answer }}</p>
                        </div>
                    </div>
                    <div class="flex shrink-0 flex-wrap gap-2">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="inline-flex min-h-11 items-center rounded-lg border border-hospital px-3 text-sm font-semibold text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-hospital">Edit</a>
                        <a href="{{ route('admin.faqs.show', $faq) }}" class="inline-flex min-h-11 items-center rounded-lg border border-[#A9B8AE] px-3 text-sm font-semibold text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-hospital">Pratinjau</a>
                        <form action="{{ route('admin.faqs.status', $faq) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="min-h-11 rounded-lg border border-[#A9B8AE] px-3 text-sm font-semibold text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-hospital">{{ $faq->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        </form>
                        <button type="button" data-delete-open data-delete-action="{{ route('admin.faqs.destroy', $faq) }}" data-delete-question="{{ $faq->question }}" class="min-h-11 rounded-lg border border-[#C68C80] px-3 text-sm font-semibold text-[#9B3028] hover:bg-[#FFF4F0] focus-visible:outline-3 focus-visible:outline-[#9B3028]">Hapus</button>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-[#D9E4DD] bg-white p-8 text-center">
                <h2 class="text-xl font-bold text-ink">{{ $search !== '' || $status !== 'all' ? 'Tidak ada FAQ yang sesuai.' : 'Belum ada FAQ.' }}</h2>
                <p class="mt-2 text-[#52615B]">{{ $search !== '' || $status !== 'all' ? 'Coba kata kunci atau status lain.' : 'Mulai dengan menambahkan pertanyaan pertama.' }}</p>
                @if ($search !== '' || $status !== 'all') <a href="{{ route('admin.faqs.index') }}" class="mt-4 inline-flex min-h-11 items-center font-semibold text-hospital underline">Lihat semua FAQ</a> @endif
            </div>
        @endforelse
    </div>

    <dialog data-delete-dialog class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border border-[#D9E4DD] bg-white p-6 text-ink shadow-xl backdrop:bg-[#26332F80]">
        <h2 class="text-xl font-bold text-hospital-deep">Hapus FAQ permanen?</h2>
        <p class="mt-3 leading-relaxed">Pertanyaan <strong data-delete-name></strong> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
        <form data-delete-form method="POST" class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            @csrf @method('DELETE')
            <button type="button" data-delete-cancel class="min-h-12 rounded-xl border border-[#627B6F] px-5 font-semibold text-hospital-deep">Batal</button>
            <button type="submit" class="min-h-12 rounded-xl bg-[#9B3028] px-5 font-bold text-white">Hapus Permanen</button>
        </form>
    </dialog>
@endsection
