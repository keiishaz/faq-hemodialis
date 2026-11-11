@extends('layouts.admin')

@section('title', $video->exists ? 'Edit Video' : 'Tambah Video')

@section('content')
    @php($editing = $video->exists)

    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-[1.625rem] font-semibold leading-tight tracking-tight text-hospital-deep">{{ $editing ? 'Edit Video' : 'Tambah Video' }}</h1>
            <p class="mt-1 text-sm text-[#52697B]">Isi judul dan tautan YouTube. Kolom tautan boleh dikosongkan bila video belum diunggah.</p>
        </div>
        <a href="{{ route('admin.videos.index') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-lg border border-[#B6D8E8] px-4 text-sm font-semibold text-hospital-deep hover:bg-sage">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="mt-6 rounded-xl border border-[#D58B87] bg-[#FFF4F3] px-4 py-3 text-sm text-[#A52D38]" role="alert">
            <ul class="list-inside list-disc space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $editing ? route('admin.videos.update', $video) : route('admin.videos.store') }}" method="POST" class="mt-6 rounded-xl border border-[#D6E5EE] bg-white p-5 sm:p-6">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="grid gap-5 lg:grid-cols-2">
            <div class="lg:col-span-2">
                <label for="judul" class="mb-1.5 block text-sm font-semibold text-hospital-deep">Judul video <span class="text-[#A52D38]">*</span></label>
                <input id="judul" name="judul" type="text" required maxlength="255" value="{{ old('judul', $video->judul) }}" class="min-h-11 w-full rounded-lg border border-[#B3C8D8] bg-white px-3 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
            </div>

            <div>
                <label for="pembicara" class="mb-1.5 block text-sm font-semibold text-hospital-deep">Nama pembicara / mahasiswa</label>
                <input id="pembicara" name="pembicara" type="text" maxlength="255" value="{{ old('pembicara', $video->pembicara) }}" class="min-h-11 w-full rounded-lg border border-[#B3C8D8] bg-white px-3 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
            </div>

            <div>
                <label for="kategori" class="mb-1.5 block text-sm font-semibold text-hospital-deep">Topik <span class="text-[#A52D38]">*</span></label>
                <input id="kategori" name="kategori" type="text" required maxlength="100" list="kategori-video" value="{{ old('kategori', $video->kategori) }}" class="min-h-11 w-full rounded-lg border border-[#B3C8D8] bg-white px-3 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
                <datalist id="kategori-video">
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="lg:col-span-2">
                <label for="youtube_url" class="mb-1.5 block text-sm font-semibold text-hospital-deep">Tautan YouTube</label>
                <input id="youtube_url" name="youtube_url" type="text" maxlength="255" placeholder="https://youtu.be/XXXXXXXXXXX" value="{{ old('youtube_url', $video->youtube_url) }}" class="min-h-11 w-full rounded-lg border border-[#B3C8D8] bg-white px-3 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
                <p class="mt-1.5 text-xs text-[#52697B]">Bentuk yang diterima: <code>youtu.be/ID</code>, <code>youtube.com/watch?v=ID</code>, <code>youtube.com/shorts/ID</code>, atau ID video saja.</p>
                @if ($editing && $video->hasVideo())
                    <div class="mt-3 flex flex-col gap-3 rounded-xl border border-[#D6E5EE] bg-paper p-3 sm:flex-row sm:items-center">
                        <img src="{{ $video->thumbnailUrl() }}" alt="Pratinjau" class="aspect-video w-40 rounded-lg object-cover">
                        <p class="text-xs leading-relaxed text-[#52697B]">Pratinjau thumbnail · ID video <span class="font-semibold text-hospital-deep">{{ $video->youtubeId() }}</span></p>
                    </div>
                @endif
            </div>

            <div>
                <label for="durasi" class="mb-1.5 block text-sm font-semibold text-hospital-deep">Durasi</label>
                <input id="durasi" name="durasi" type="text" maxlength="40" placeholder="10–15 menit" value="{{ old('durasi', $video->durasi) }}" class="min-h-11 w-full rounded-lg border border-[#B3C8D8] bg-white px-3 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">
            </div>

            <div class="flex items-end">
                <label class="flex min-h-11 items-center gap-2.5 rounded-lg border border-[#B3C8D8] px-3 text-sm font-medium text-hospital-deep">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $video->is_active ?? true)) class="size-4 rounded border-[#6E899A] text-hospital focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    Tampilkan di halaman publik
                </label>
            </div>

            <div class="lg:col-span-2">
                <label for="deskripsi" class="mb-1.5 block text-sm font-semibold text-hospital-deep">Deskripsi singkat <span class="font-normal text-[#52697B]">(opsional)</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="2000" class="w-full rounded-lg border border-[#B3C8D8] bg-white px-3 py-2 text-sm outline-none focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-sage">{{ old('deskripsi', $video->deskripsi) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-2 border-t border-[#E4EFF5] pt-5">
            <button type="submit" class="inline-flex min-h-11 items-center rounded-lg bg-hospital px-5 text-sm font-semibold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">{{ $editing ? 'Simpan perubahan' : 'Tambah video' }}</button>
            <a href="{{ route('admin.videos.index') }}" class="inline-flex min-h-11 items-center rounded-lg border border-[#B6D8E8] px-5 text-sm font-semibold text-hospital-deep hover:bg-sage">Batal</a>
        </div>
    </form>
@endsection
