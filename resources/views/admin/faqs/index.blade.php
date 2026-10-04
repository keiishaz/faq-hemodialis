@extends('layouts.admin')

@section('title', 'Kelola FAQ')

@section('content')
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-[1.625rem] font-semibold leading-tight tracking-tight text-hospital-deep">Kelola FAQ</h1>
            <p class="mt-1 text-sm text-[#52697B]">Kelola pertanyaan dan status publikasi.</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-lg bg-hospital px-4 text-sm font-semibold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep"><span class="admin-icon admin-icon-plus" aria-hidden="true"></span>Tambah FAQ</a>
    </div>

    @if (session('status'))
        <div class="mt-7 rounded-xl border border-[#9DD4E8] bg-sage px-4 py-3 font-medium text-hospital-deep" role="status">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mt-7 rounded-xl border border-[#D58B87] bg-[#FFF4F3] px-4 py-3 font-medium text-[#A52D38]" role="alert">{{ session('error') }}</div>
    @endif

    <div class="mt-6 rounded-t-xl border border-b-0 border-[#D6E5EE] bg-white p-4">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center">
        <form action="{{ route('admin.faqs.index') }}" method="GET" class="relative min-w-0 flex-1">
            @if ($status !== 'all') <input type="hidden" name="status" value="{{ $status }}"> @endif
            <label for="faq-search" class="sr-only">Cari pertanyaan FAQ</label>
            <input id="faq-search" name="search" type="search" value="{{ $search }}" placeholder="Cari pertanyaan FAQ..." class="min-h-11 w-full rounded-lg border border-[#B3C8D8] bg-white py-2 pl-12 pr-4 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
            <button type="submit" aria-label="Cari FAQ" class="absolute inset-y-0 left-0 flex w-11 items-center justify-center rounded-l-lg text-hospital hover:bg-sage focus-visible:outline-3 focus-visible:-outline-offset-3 focus-visible:outline-hospital"><span class="admin-icon admin-icon-search" aria-hidden="true"></span></button>
        </form>
        <nav aria-label="Filter status FAQ" class="flex shrink-0 flex-wrap gap-1 rounded-lg bg-paper p-1">
            @foreach (['all' => 'Semua', 'active' => 'Aktif', 'inactive' => 'Nonaktif'] as $value => $label)
                <a href="{{ route('admin.faqs.index', array_filter(['status' => $value === 'all' ? null : $value, 'search' => $search === '' ? null : $search])) }}" @if ($status === $value) aria-current="page" @endif class="inline-flex min-h-10 items-center rounded-md px-3 text-sm font-medium focus-visible:outline-3 focus-visible:outline-hospital sm:px-4 {{ $status === $value ? 'bg-hospital font-semibold text-white' : 'text-[#52697B] hover:bg-sage' }}">{{ $label }}</a>
            @endforeach
        </nav>
        </div>
    <div class="mt-2 flex flex-wrap items-center justify-between gap-2 border-t border-[#D6E5EE] pt-2 text-sm">
        <p id="reorder-help" class="flex items-start gap-1.5 text-[#52697B]">
            <span class="admin-icon admin-icon-drag mt-0.5 !size-4" aria-hidden="true"></span>
            @if ($reorderEnabled)
                Seret pegangan untuk mengubah urutan FAQ. Dengan keyboard, gunakan panah atas atau bawah.
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
    </div>

    <div data-reorder-list @if ($reorderEnabled) data-reorder-url="{{ route('admin.faqs.reorder') }}" data-reorder-snapshot="{{ $orderSnapshot }}" data-reorder-token="{{ csrf_token() }}" data-login-url="{{ route('admin.login') }}" @endif class="overflow-hidden rounded-b-xl border border-[#D6E5EE] bg-white">
        <div class="hidden grid-cols-[minmax(0,1fr)_96px_126px_284px] gap-4 border-b border-[#D6E5EE] bg-paper px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.05em] text-[#52697B] xl:grid">
            <span class="pl-13">Pertanyaan</span><span>Status</span><span>Diperbarui</span><span>Aksi</span>
        </div>
        @forelse ($faqs as $faq)
            <article data-sort-item data-sort-id="{{ $faq->id }}" class="faq-sort-item grid gap-3 border-b border-[#E2EDF3] bg-white p-4 last:border-b-0 sm:px-5 sm:py-3 xl:grid-cols-[minmax(0,1fr)_96px_126px_284px] xl:items-center xl:gap-4">
                    <div class="flex min-w-0 items-center gap-3">
                        <button type="button" data-sort-handle @disabled(! $reorderEnabled) aria-label="Pindahkan FAQ: {{ $faq->question }}" aria-describedby="reorder-help" title="Ubah urutan FAQ" class="flex size-10 shrink-0 touch-none items-center justify-center rounded-lg text-[#60788D] hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital disabled:cursor-not-allowed disabled:opacity-50"><span class="admin-icon admin-icon-drag" aria-hidden="true"></span></button>
                        <div class="min-w-0">
                            <h2 class="text-sm font-medium leading-snug text-ink">{{ $faq->question }}</h2>
                            <p class="mt-1 line-clamp-1 whitespace-pre-line text-sm leading-relaxed text-[#52697B] xl:hidden">{{ $faq->short_answer }}</p>
                        </div>
                    </div>
                    <span class="inline-flex w-fit items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $faq->is_active ? 'bg-[#E7F6EE] text-[#176247]' : 'bg-[#EBF0F4] text-[#52697B]' }}"><span aria-hidden="true" class="size-1.5 rounded-full bg-current"></span>{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    <span class="text-sm text-[#52697B]"><span class="xl:hidden">Diperbarui </span>{{ $faq->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                    <div class="flex flex-wrap items-center gap-2 border-t border-[#E2EDF3] pt-3 xl:border-t-0 xl:pt-0">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" aria-label="Edit FAQ: {{ $faq->question }}" title="Edit FAQ" class="inline-flex size-10 items-center justify-center rounded-lg border border-[#D6E5EE] text-hospital hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital"><span class="admin-icon admin-icon-edit" aria-hidden="true"></span></a>
                        <a href="{{ route('admin.faqs.show', $faq) }}" aria-label="Pratinjau FAQ: {{ $faq->question }}" title="Pratinjau FAQ" class="inline-flex size-10 items-center justify-center rounded-lg border border-[#D6E5EE] text-hospital hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital"><span class="admin-icon admin-icon-preview" aria-hidden="true"></span></a>
                        <form action="{{ route('admin.faqs.status', $faq) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="inline-flex min-h-10 items-center gap-1.5 rounded-lg border border-[#D6E5EE] px-2.5 text-sm font-medium text-[#52697B] hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital"><span class="admin-icon {{ $faq->is_active ? 'admin-icon-hide' : 'admin-icon-active' }} !size-4" aria-hidden="true"></span>{{ $faq->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        </form>
                        <button type="button" data-delete-open data-delete-action="{{ route('admin.faqs.destroy', $faq) }}" data-delete-question="{{ $faq->question }}" aria-label="Hapus FAQ: {{ $faq->question }}" title="Hapus FAQ" class="inline-flex size-10 items-center justify-center rounded-lg bg-[#FFF0F1] text-[#B42335] hover:bg-[#FADDE0] focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-[#B42335]"><span class="admin-icon admin-icon-delete" aria-hidden="true"></span></button>
                    </div>
            </article>
        @empty
            <div class="p-8 text-center">
                <h2 class="text-lg font-semibold text-ink">{{ $search !== '' || $status !== 'all' ? 'Tidak ada FAQ yang sesuai.' : 'Belum ada FAQ.' }}</h2>
                <p class="mt-2 text-[#52697B]">{{ $search !== '' || $status !== 'all' ? 'Coba kata kunci atau status lain.' : 'Mulai dengan menambahkan pertanyaan pertama.' }}</p>
                @if ($search !== '' || $status !== 'all') <a href="{{ route('admin.faqs.index') }}" class="mt-4 inline-flex min-h-11 items-center font-semibold text-hospital underline">Lihat semua FAQ</a> @endif
            </div>
        @endforelse
    </div>

    <dialog data-delete-dialog class="m-auto w-[calc(100%-2rem)] max-w-xl rounded-2xl border border-[#D6E5EE] bg-white p-7 text-ink shadow-xl backdrop:bg-[#17364E66] sm:p-8">
        <div class="flex items-start justify-between gap-4">
            <span aria-hidden="true" class="flex size-12 items-center justify-center rounded-xl bg-[#FFF0F1] text-[#B42335]"><span class="admin-icon admin-icon-delete"></span></span>
            <form method="dialog"><button type="submit" aria-label="Tutup dialog" class="flex size-10 items-center justify-center rounded-lg text-2xl font-light text-[#52697B] hover:bg-paper focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">×</button></form>
        </div>
        <h2 class="mt-5 text-2xl font-semibold text-hospital-deep">Hapus FAQ secara permanen?</h2>
        <p class="mt-3 leading-relaxed text-[#52697B]">FAQ berikut akan dihapus dari daftar dan tidak dapat dipulihkan.</p>
        <div class="mt-5 rounded-lg border border-[#D6E5EE] bg-paper p-4">
            <p class="text-xs font-semibold uppercase tracking-[0.05em] text-[#52697B]">Pertanyaan</p>
            <p data-delete-name class="mt-1 font-semibold text-hospital-deep"></p>
        </div>
        <p class="mt-5 flex items-start gap-2 text-sm leading-relaxed text-[#B42335]"><span class="admin-icon admin-icon-info mt-0.5 !size-4" aria-hidden="true"></span>Tindakan ini tidak dapat dibatalkan.</p>
        <form data-delete-form method="POST" class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            @csrf @method('DELETE')
            <button type="button" data-delete-cancel class="min-h-11 rounded-lg border border-[#D6E5EE] px-5 font-medium text-hospital-deep">Batal</button>
            <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg bg-[#B42335] px-5 font-semibold text-white"><span class="admin-icon admin-icon-delete !size-4" aria-hidden="true"></span>Hapus Permanen</button>
        </form>
    </dialog>
@endsection
