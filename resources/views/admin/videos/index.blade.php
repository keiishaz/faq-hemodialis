@extends('layouts.admin')

@section('title', 'Kelola Video')

@section('content')
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-[1.625rem] font-semibold leading-tight tracking-tight text-hospital-deep">Kelola Video Edukasi</h1>
            <p class="mt-1 text-sm text-[#52697B]">{{ $totalSemua }} judul terdaftar · {{ $totalSiap }} sudah punya tautan YouTube · {{ $totalSemua - $totalSiap }} menunggu unggahan.</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-lg bg-hospital px-4 text-sm font-semibold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep"><span class="admin-icon admin-icon-plus" aria-hidden="true"></span>Tambah Video</a>
    </div>

    @if (session('status'))
        <div class="mt-7 rounded-xl border border-[#9DD4E8] bg-sage px-4 py-3 font-medium text-hospital-deep" role="status">{{ session('status') }}</div>
    @endif

    <div class="mt-6 rounded-xl border border-[#D6E5EE] bg-white p-4">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center">
            <form action="{{ route('admin.videos.index') }}" method="GET" class="relative min-w-0 flex-1">
                @if ($status !== 'all') <input type="hidden" name="status" value="{{ $status }}"> @endif
                <label for="video-search" class="sr-only">Cari video</label>
                <input id="video-search" name="search" type="search" value="{{ $search }}" placeholder="Cari judul, pembicara, atau topik..." class="min-h-11 w-full rounded-lg border border-[#B3C8D8] bg-white py-2 pl-12 pr-4 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
                <button type="submit" aria-label="Cari video" class="absolute inset-y-0 left-0 flex w-11 items-center justify-center rounded-l-lg text-hospital hover:bg-sage focus-visible:outline-3 focus-visible:-outline-offset-3 focus-visible:outline-hospital"><span class="admin-icon admin-icon-search" aria-hidden="true"></span></button>
            </form>
            <nav aria-label="Filter status video" class="flex shrink-0 flex-wrap gap-1 rounded-lg bg-paper p-1">
                @foreach (['all' => 'Semua', 'ready' => 'Siap', 'draft' => 'Belum ada link', 'inactive' => 'Disembunyikan'] as $value => $label)
                    <a href="{{ route('admin.videos.index', array_filter(['status' => $value === 'all' ? null : $value, 'search' => $search === '' ? null : $search])) }}" @if ($status === $value) aria-current="page" @endif class="inline-flex min-h-10 items-center rounded-md px-3 text-sm font-medium focus-visible:outline-3 focus-visible:outline-hospital sm:px-4 {{ $status === $value ? 'bg-hospital font-semibold text-white' : 'text-[#52697B] hover:bg-sage' }}">{{ $label }}</a>
                @endforeach
            </nav>
        </div>
    </div>

    <div class="overflow-hidden rounded-b-xl border border-t-0 border-[#D6E5EE] bg-white">
        @forelse ($videos as $video)
            <div class="flex flex-col gap-3 border-b border-[#E4EFF5] p-4 last:border-b-0 sm:flex-row sm:items-center sm:gap-4">
                <div class="relative aspect-video w-full shrink-0 overflow-hidden rounded-lg bg-[#0C2E45] sm:w-32">
                    @if ($video->thumbnailUrl())
                        <img src="{{ $video->thumbnailUrl() }}" alt="" loading="lazy" class="size-full object-cover">
                    @else
                        <span class="absolute inset-0 bg-gradient-to-br from-[#0B3F63] to-[#08243A]"></span>
                        <span aria-hidden="true" class="absolute inset-0 flex items-center justify-center text-[11px] font-semibold text-white/70">tanpa video</span>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded bg-sage px-2 py-0.5 text-[11px] font-semibold text-hospital-deep">{{ $video->kategori }}</span>
                        @if ($video->is_active)
                            <span class="rounded bg-[#E7F6EC] px-2 py-0.5 text-[11px] font-semibold text-[#1B7A4B]">Tampil</span>
                        @else
                            <span class="rounded bg-[#F1F3F5] px-2 py-0.5 text-[11px] font-semibold text-[#6B7A86]">Disembunyikan</span>
                        @endif
                        @unless ($video->hasVideo())
                            <span class="rounded bg-[#FBF3DC] px-2 py-0.5 text-[11px] font-semibold text-[#8A6D1F]">Belum ada link</span>
                        @endunless
                    </div>
                    <p class="mt-1.5 truncate text-sm font-semibold text-hospital-deep">{{ $video->judul }}</p>
                    <p class="mt-0.5 truncate text-xs text-[#52697B]">
                        {{ $video->pembicara ?: 'Tanpa nama pembicara' }}
                        @if ($video->durasi) · {{ $video->durasi }} @endif
                        @if ($video->youtubeId()) · ID: {{ $video->youtubeId() }} @endif
                    </p>
                </div>

                <div class="flex shrink-0 flex-wrap items-center gap-1.5">
                    <a href="{{ route('public.videos.show', $video) }}" target="_blank" rel="noopener" class="inline-flex min-h-9 items-center rounded-lg border border-[#B6D8E8] px-3 text-xs font-semibold text-hospital-deep hover:bg-sage">Lihat</a>
                    <a href="{{ route('admin.videos.edit', $video) }}" class="inline-flex min-h-9 items-center rounded-lg border border-[#B6D8E8] px-3 text-xs font-semibold text-hospital-deep hover:bg-sage">Edit</a>
                    <form action="{{ route('admin.videos.toggle', $video) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex min-h-9 items-center rounded-lg border border-[#B6D8E8] px-3 text-xs font-semibold text-hospital-deep hover:bg-sage">{{ $video->is_active ? 'Sembunyikan' : 'Tampilkan' }}</button>
                    </form>
                    <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex min-h-9 items-center rounded-lg border border-[#D58B87] px-3 text-xs font-semibold text-[#A52D38] hover:bg-[#FFF4F3]">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="px-4 py-10 text-center text-sm text-[#52697B]">Tidak ada video yang cocok dengan filter ini.</p>
        @endforelse
    </div>
@endsection
