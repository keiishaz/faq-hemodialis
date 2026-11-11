@extends('layouts.public', ['publicPageType' => 'video'])

@section('content')
    <div class="border-b border-[#DCEAF2] bg-white">
        <nav aria-label="Remah roti" class="mx-auto max-w-6xl px-5 py-3 text-sm sm:px-8">
            <ol class="flex flex-wrap items-center gap-1.5 text-[#52697B]">
                <li><a href="{{ route('public.index') }}" class="rounded font-medium text-hospital hover:underline focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">Beranda</a></li>
                <li aria-hidden="true" class="text-[#9FB4C2]">/</li>
                <li><a href="{{ route('public.videos.index') }}" class="rounded font-medium text-hospital hover:underline focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">Video Edukasi</a></li>
                <li aria-hidden="true" class="text-[#9FB4C2]">/</li>
                <li class="min-w-0 max-w-[60ch] truncate" aria-current="page">{{ $video->judul }}</li>
            </ol>
        </nav>
    </div>

    <section class="mx-auto max-w-6xl px-5 py-7 sm:px-8 sm:py-9">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_20rem]">
            <div class="min-w-0">
                <div class="overflow-hidden rounded-2xl border border-[#123A54] bg-[#061B2A] shadow-[0_18px_40px_rgb(6_27_42_/_22%)]">
                    @if ($video->embedUrl())
                        <div class="relative aspect-video">
                            <iframe
                                src="{{ $video->embedUrl() }}"
                                title="Video edukasi: {{ $video->judul }}"
                                class="absolute inset-0 size-full"
                                loading="lazy"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    @else
                        <div class="relative flex aspect-video flex-col items-center justify-center gap-3 px-6 text-center">
                            <span aria-hidden="true" class="absolute inset-0 opacity-[0.13]" style="background-image:radial-gradient(circle at 1px 1px, #fff 1px, transparent 0);background-size:16px 16px;"></span>
                            <span class="flex size-14 items-center justify-center rounded-full border border-white/25 bg-white/10 text-white">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="size-6"><circle cx="12" cy="12" r="8.5" /><path d="M12 8v4.5l3 1.8" /></svg>
                            </span>
                            <p class="text-base font-semibold text-white">Video belum tersedia</p>
                            <p class="max-w-md text-sm leading-relaxed text-[#B9D7E8]">Judul ini sudah terdaftar, tetapi tautan videonya belum diunggah. Silakan periksa kembali nanti atau tonton video lain yang sudah tersedia.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center rounded-md bg-sage px-2.5 py-1 text-xs font-semibold text-hospital-deep">{{ $video->kategori }}</span>
                        @if ($video->durasi)
                            <span class="inline-flex items-center gap-1 rounded-md border border-[#CFE3EE] px-2.5 py-1 text-xs font-medium text-[#52697B]">
                                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="size-3.5"><circle cx="12" cy="12" r="8.5" /><path d="M12 7.5V12l3 1.8" /></svg>
                                {{ $video->durasi }}
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-xs font-semibold {{ $video->hasVideo() ? 'bg-[#E7F6EC] text-[#1B7A4B]' : 'bg-[#FBF3DC] text-[#8A6D1F]' }}">
                            <span aria-hidden="true" class="size-1.5 rounded-full {{ $video->hasVideo() ? 'bg-[#1B7A4B]' : 'bg-[#C9A227]' }}"></span>
                            {{ $video->hasVideo() ? 'Siap ditonton' : 'Menunggu unggahan' }}
                        </span>
                    </div>

                    <h1 class="mt-3 text-[1.6rem] font-semibold leading-snug tracking-tight text-hospital-deep sm:text-[2rem]">{{ $video->judul }}</h1>

                    <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-[#52697B]">
                        @if ($video->pembicara)
                            <p class="flex items-center gap-1.5">
                                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-4 shrink-0"><circle cx="12" cy="8" r="3.5" /><path d="M5 20a7 7 0 0 1 14 0" /></svg>
                                <span>oleh <span class="font-semibold text-hospital-deep">{{ $video->pembicara }}</span></span>
                            </p>
                        @endif
                        <p class="flex items-center gap-1.5">
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="size-4 shrink-0"><path d="M4 6h16M4 12h16M4 18h10" /></svg>
                            <span>Prodi Promosi Kesehatan · Poltekkes Kemenkes Bengkulu</span>
                        </p>
                    </div>

                    <div class="mt-6 rounded-2xl border border-[#D7E8F1] bg-white p-5 sm:p-6">
                        <h2 class="text-base font-semibold text-hospital-deep">Tentang video ini</h2>
                        <div class="mt-2 space-y-3 text-sm leading-[1.7] text-[#33495A] sm:text-base">
                            @if ($video->deskripsi)
                                @foreach (preg_split('/\R(?:[ \t]*\R)+/u', trim($video->deskripsi)) as $paragraph)
                                    <p class="whitespace-pre-line">{{ trim($paragraph) }}</p>
                                @endforeach
                            @else
                                <p>Video edukasi ini membahas <span class="font-medium text-hospital-deep">{{ $video->judul }}</span> sebagai bagian dari topik {{ $video->kategori }} dalam perawatan penyakit ginjal dan hemodialisis.</p>
                                <p>Materi disusun oleh {{ $video->pembicara ?: 'mahasiswa Program Studi Promosi Kesehatan' }} untuk membantu pasien, keluarga, dan masyarakat memahami informasi kesehatan ginjal dengan bahasa yang mudah dipahami.</p>
                            @endif
                        </div>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @if ($video->watchUrl())
                                <a href="{{ $video->watchUrl() }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-hospital px-4 text-sm font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path d="M23 12s0-3.9-.5-5.7a3 3 0 0 0-2.1-2.1C18.6 3.7 12 3.7 12 3.7s-6.6 0-8.4.5A3 3 0 0 0 1.5 6.3C1 8.1 1 12 1 12s0 3.9.5 5.7a3 3 0 0 0 2.1 2.1c1.8.5 8.4.5 8.4.5s6.6 0 8.4-.5a3 3 0 0 0 2.1-2.1C23 15.9 23 12 23 12ZM9.8 15.6V8.4l6.2 3.6-6.2 3.6Z" /></svg>
                                    Buka di YouTube
                                </a>
                            @endif
                            <a href="{{ route('public.videos.index', ['kategori' => $video->kategori]) }}" class="inline-flex min-h-11 items-center gap-2 rounded-xl border border-[#B6D8E8] px-4 text-sm font-semibold text-hospital-deep transition-colors hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                                Video lain di topik ini
                            </a>
                            <a href="{{ route('public.index') }}" class="inline-flex min-h-11 items-center gap-2 rounded-xl border border-[#B6D8E8] px-4 text-sm font-semibold text-hospital-deep transition-colors hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                                Kembali ke tanya jawab
                            </a>
                        </div>
                    </div>

                    <p class="mt-4 rounded-xl border border-[#D7E8F1] bg-white px-4 py-3 text-xs leading-relaxed text-[#52697B]">
                        Video ditampilkan melalui pemutar YouTube. Informasi dalam video bersifat edukatif dan bukan pengganti konsultasi medis. Selalu ikuti anjuran dokter atau tenaga kesehatan yang menangani Anda.
                    </p>
                </div>
            </div>

            <aside aria-label="Video lainnya" class="min-w-0">
                <div class="rounded-2xl border border-[#D7E8F1] bg-white p-4 sm:p-5">
                    <h2 class="text-base font-semibold text-hospital-deep">Video lainnya</h2>
                    <ul class="mt-3 space-y-3">
                        @foreach ($lainnya as $lain)
                            <li>
                                <a href="{{ route('public.videos.show', $lain) }}" class="group flex gap-3 rounded-xl p-1.5 transition-colors hover:bg-[#F3FAFD] focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                                    <span class="relative block aspect-video w-28 shrink-0 overflow-hidden rounded-lg bg-[#0C2E45]">
                                        @if ($lain->thumbnailUrl())
                                            <img src="{{ $lain->thumbnailUrl() }}" alt="" loading="lazy" class="size-full object-cover">
                                        @else
                                            <span class="absolute inset-0 bg-gradient-to-br from-[#0B3F63] to-[#08243A]"></span>
                                        @endif
                                        <span aria-hidden="true" class="absolute inset-0 flex items-center justify-center">
                                            <span class="flex size-7 items-center justify-center rounded-full bg-white/90">
                                                <svg viewBox="0 0 24 24" fill="currentColor" class="ml-0.5 size-3 text-hospital"><path d="M8 5.14v13.72a1 1 0 0 0 1.55.83l10.2-6.86a1 1 0 0 0 0-1.66L9.55 4.31A1 1 0 0 0 8 5.14Z" /></svg>
                                            </span>
                                        </span>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="line-clamp-3 block text-sm font-medium leading-snug text-hospital-deep group-hover:text-hospital">{{ $lain->judul }}</span>
                                        <span class="mt-1 block text-xs text-[#52697B]">{{ $lain->kategori }}</span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('public.videos.index') }}" class="mt-4 inline-flex min-h-10 w-full items-center justify-center gap-1.5 rounded-xl border border-[#B6D8E8] text-sm font-semibold text-hospital-deep transition-colors hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                        Lihat semua video
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
