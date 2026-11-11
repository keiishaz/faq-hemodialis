@extends('layouts.admin')

@section('title', 'Kelola Video')

@section('content')
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-[1.625rem] font-semibold leading-tight tracking-tight text-hospital-deep">Kelola Video Edukasi</h1>
            <p class="mt-1 text-sm text-[#52697B]">{{ $totalSemua }} judul terdaftar · {{ $totalSiap }} sudah punya tautan YouTube · {{ $totalSemua - $totalSiap }} menunggu unggahan.</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-lg border border-[#B6D8E8] px-4 text-sm font-semibold text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">Tambah lengkap</a>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded-xl border border-[#9DD4E8] bg-sage px-4 py-3 font-medium text-hospital-deep" role="status">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mt-6 rounded-xl border border-[#D58B87] bg-[#FFF4F3] px-4 py-3 font-medium text-[#A52D38]" role="alert">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="mt-6 rounded-xl border border-[#D58B87] bg-[#FFF4F3] px-4 py-3 text-sm text-[#A52D38]" role="alert">{{ $errors->first() }}</div>
    @endif

    <!-- Tambah cepat: cukup tempel tautan YouTube -->
    <div class="mt-6 rounded-xl border border-[#9DD4E8] bg-[#F3FAFD] p-4 sm:p-5">
        <div class="flex items-start gap-3">
            <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-hospital text-white">
                <svg aria-hidden="true" viewBox="0 0 24 24" fill="currentColor" class="ml-0.5 size-4"><path d="M8 5.14v13.72a1 1 0 0 0 1.55.83l10.2-6.86a1 1 0 0 0 0-1.66L9.55 4.31A1 1 0 0 0 8 5.14Z" /></svg>
            </span>
            <div class="min-w-0">
                <h2 class="text-sm font-semibold text-hospital-deep">Tambah cepat dari tautan YouTube</h2>
                <p class="mt-0.5 text-xs leading-relaxed text-[#52697B]">Tempel tautan, judul dan nama kanal diambil otomatis dari YouTube. Tidak perlu mengetik judul.</p>
            </div>
        </div>

        <form action="{{ route('admin.videos.quick') }}" method="POST" class="mt-3 flex flex-col gap-2 lg:flex-row">
            @csrf
            <label for="quick-url" class="sr-only">Tautan YouTube</label>
            <input id="quick-url" name="youtube_url" type="text" required value="{{ old('youtube_url') }}" placeholder="https://youtu.be/XXXXXXXXXXX" class="min-h-11 min-w-0 flex-1 rounded-lg border border-[#B3C8D8] bg-white px-3 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
            <label for="quick-kategori" class="sr-only">Topik</label>
            <input id="quick-kategori" name="kategori" type="text" list="kategori-video" value="{{ old('kategori') }}" placeholder="Topik (opsional)" class="min-h-11 rounded-lg border border-[#B3C8D8] bg-white px-3 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage lg:w-56">
            <datalist id="kategori-video">
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori }}"></option>
                @endforeach
            </datalist>
            <button type="submit" class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg bg-hospital px-5 text-sm font-semibold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">Tambahkan</button>
        </form>
    </div>

    <!-- Daftar video tanpa tautan: isi link langsung di baris -->
    @php($tanpaLink = $videos->reject(fn ($v) => $v->hasVideo())->take(8))

    <div class="mt-6 rounded-t-xl border border-b-0 border-[#D6E5EE] bg-white p-4">
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
            <div class="border-b border-[#E4EFF5] p-4 last:border-b-0">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">
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
                        <p class="mt-1.5 text-sm font-semibold text-hospital-deep">{{ $video->judul }}</p>
                        <p class="mt-0.5 truncate text-xs text-[#52697B]">
                            {{ $video->pembicara ?: 'Tanpa nama pembicara' }}
                            @if ($video->durasi) · {{ $video->durasi }} @endif
                            @if ($video->youtubeId()) · youtu.be/{{ $video->youtubeId() }} @endif
                        </p>

                        @unless ($video->hasVideo())
                            <form action="{{ route('admin.videos.link', $video) }}" method="POST" class="mt-2 flex flex-col gap-1.5 sm:flex-row">
                                @csrf
                                @method('PATCH')
                                <label for="link-{{ $video->id }}" class="sr-only">Tautan YouTube untuk {{ $video->judul }}</label>
                                <input id="link-{{ $video->id }}" name="youtube_url" type="text" required placeholder="Tempel tautan YouTube di sini…" class="min-h-9 min-w-0 flex-1 rounded-lg border border-[#B3C8D8] px-2.5 text-xs outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
                                <button type="submit" class="inline-flex min-h-9 shrink-0 items-center justify-center rounded-lg bg-hospital px-3 text-xs font-semibold text-white hover:bg-hospital-deep">Simpan link</button>
                            </form>
                        @endunless
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
            </div>
        @empty
            <p class="px-4 py-10 text-center text-sm text-[#52697B]">Tidak ada video yang cocok dengan filter ini.</p>
        @endforelse
    </div>
@endsection
