@extends('layouts.admin')

@section('title', 'Kelola Topik Video')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-[1.625rem] font-semibold leading-tight tracking-tight text-hospital-deep">Topik Video</h1>
            <p class="mt-1 text-sm text-[#52697B]">{{ $topics->count() }} topik terdaftar · {{ $totalVideo }} video total. Topik dipakai untuk mengelompokkan video di halaman publik.</p>
        </div>
        <a href="{{ route('admin.videos.index') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg border border-[#B6D8E8] px-4 text-sm font-semibold text-hospital-deep hover:bg-sage">Kelola video</a>
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

    <div class="mt-6 rounded-xl border border-[#9DD4E8] bg-[#F3FAFD] p-4 sm:p-5">
        <h2 class="text-sm font-semibold text-hospital-deep">Tambah topik baru</h2>
        <p class="mt-0.5 text-xs leading-relaxed text-[#52697B]">Contoh: Hipertensi, Diabetes Melitus, Hemodialisis, Cuci Darah Mandiri.</p>
        <form action="{{ route('admin.topics.store') }}" method="POST" class="mt-3 flex flex-col gap-2 sm:flex-row">
            @csrf
            <label for="nama-topik" class="sr-only">Nama topik baru</label>
            <input id="nama-topik" name="nama" type="text" required maxlength="100" value="{{ old('nama') }}" placeholder="Nama topik baru…" class="min-h-11 min-w-0 flex-1 rounded-lg border border-[#B3C8D8] bg-white px-3 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
            <button type="submit" class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg bg-hospital px-5 text-sm font-semibold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">Tambah topik</button>
        </form>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-[#D6E5EE] bg-white">
        <div class="flex items-center justify-between border-b border-[#E4EFF5] px-4 py-3">
            <h2 class="text-sm font-semibold text-hospital-deep">Daftar topik</h2>
            <span class="text-xs text-[#52697B]">Ubah nama = otomatis memperbarui semua video</span>
        </div>

        @forelse ($topics as $item)
            @php($topic = $item['model'])
            <div class="flex flex-col gap-3 border-b border-[#E4EFF5] p-4 last:border-b-0 sm:flex-row sm:items-center">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm font-semibold text-hospital-deep">{{ $topic->nama }}</span>
                        <span class="rounded bg-sage px-2 py-0.5 text-[11px] font-semibold text-hospital-deep">{{ $item['jumlah'] }} video</span>
                    </div>
                </div>

                <form action="{{ route('admin.topics.update', $topic) }}" method="POST" class="flex flex-1 flex-col gap-1.5 sm:max-w-md sm:flex-row sm:items-center">
                    @csrf
                    @method('PUT')
                    <label for="topik-{{ $topic->id }}" class="sr-only">Ubah nama topik {{ $topic->nama }}</label>
                    <input id="topik-{{ $topic->id }}" name="nama" type="text" required maxlength="100" value="{{ $topic->nama }}" class="min-h-9 min-w-0 flex-1 rounded-lg border border-[#B3C8D8] px-2.5 text-xs outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
                    <button type="submit" class="inline-flex min-h-9 shrink-0 items-center justify-center rounded-lg border border-[#B6D8E8] px-3 text-xs font-semibold text-hospital-deep hover:bg-sage">Simpan</button>
                </form>

                <form action="{{ route('admin.topics.destroy', $topic) }}" method="POST" onsubmit="return confirm('Hapus topik {{ $topic->nama }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex min-h-9 items-center rounded-lg border border-[#D58B87] px-3 text-xs font-semibold text-[#A52D38] hover:bg-[#FFF4F3]">Hapus</button>
                </form>
            </div>
        @empty
            <p class="px-4 py-8 text-center text-sm text-[#52697B]">Belum ada topik. Tambahkan lewat formulir di atas.</p>
        @endforelse
    </div>

    @if ($tanpaTopik->isNotEmpty())
        <div class="mt-6 rounded-xl border border-[#E8D9A8] bg-[#FDF8E9] p-4">
            <h2 class="text-sm font-semibold text-[#8A6D1F]">Topik dipakai video tapi belum terdaftar</h2>
            <p class="mt-0.5 text-xs text-[#8A6D1F]">Tambahkan agar muncul di daftar pilihan topik.</p>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($tanpaTopik as $nama)
                    <form action="{{ route('admin.topics.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nama" value="{{ $nama }}">
                        <button type="submit" class="inline-flex min-h-9 items-center gap-1.5 rounded-lg border border-[#D9C27A] bg-white px-3 text-xs font-semibold text-[#8A6D1F] hover:bg-[#FBF3DC]">
                            + {{ $nama }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    @endif
@endsection
