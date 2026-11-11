@extends('layouts.public', ['publicPageType' => 'video'])

@section('content')
    <div class="public-hero px-5 pb-24 pt-11 text-white sm:px-8 sm:pb-28 sm:pt-14">
        <div class="mx-auto max-w-4xl text-center">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/12 px-4 py-1.5 text-xs font-semibold tracking-wide uppercase">
                <svg aria-hidden="true" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path d="M8 5.14v13.72a1 1 0 0 0 1.55.83l10.2-6.86a1 1 0 0 0 0-1.66L9.55 4.31A1 1 0 0 0 8 5.14Z" /></svg>
                Video Edukasi
            </span>
            <h1 class="mt-4 text-[2rem] font-semibold leading-[1.15] tracking-tight sm:text-[2.6rem]">Belajar Lewat Video, Pahami Ginjal &amp; Hemodialisis</h1>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-[#E8F8FF] sm:text-lg">
                Kumpulan video edukasi singkat yang disusun oleh mahasiswa Program Studi Promosi Kesehatan Kelas 3A, Poltekkes Kemenkes Bengkulu, sebagai sarana pembelajaran pasien dan keluarga.
            </p>

            <dl class="mx-auto mt-7 grid max-w-md grid-cols-2 gap-3 text-center sm:gap-4">
                <div class="rounded-xl border border-white/20 bg-white/10 px-3 py-3">
                    <dt class="text-[11px] font-medium tracking-wide uppercase text-[#D6EEFB]">Video tersedia</dt>
                    <dd class="mt-1 text-2xl font-semibold">{{ $total }}</dd>
                </div>
                <div class="rounded-xl border border-white/20 bg-white/10 px-3 py-3">
                    <dt class="text-[11px] font-medium tracking-wide uppercase text-[#D6EEFB]">Topik</dt>
                    <dd class="mt-1 text-2xl font-semibold">{{ $kategoris->count() }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <section class="mx-auto max-w-6xl px-5 pb-16 sm:px-8 sm:pb-20" aria-label="Daftar video edukasi">
        <div class="faq-search-shell relative -mt-12 rounded-2xl border border-[#D8E9F2] bg-white p-5 sm:-mt-14 sm:p-6">
            <form action="{{ route('public.videos.index') }}" method="GET" role="search">
                @if ($kategoriAktif !== '')
                    <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                @endif
                <label for="video-search" class="mb-2 block text-sm font-semibold text-hospital-deep">Cari video</label>
                <div class="flex flex-col gap-2 sm:flex-row">
                    <div class="relative flex-1">
                        <span aria-hidden="true" class="admin-icon admin-icon-search public-search-icon"></span>
                        <input id="video-search" name="q" type="search" value="{{ $search }}" placeholder="Cari judul, topik, atau nama pembicara...." autocomplete="off" class="min-h-12 w-full rounded-xl border border-[#6E899A] bg-white py-3 pl-12 pr-4 text-base text-ink placeholder:text-[#5B7080] focus:border-hospital focus:outline-3 focus:outline-offset-2 focus:outline-hospital">
                    </div>
                    <button type="submit" class="ui-press inline-flex min-h-12 items-center justify-center rounded-xl bg-hospital px-6 text-base font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">Cari</button>
                </div>
            </form>

            @if ($kategoris->isNotEmpty())
                <nav aria-label="Filter topik" class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('public.videos.index', $search === '' ? [] : ['q' => $search]) }}" @if ($kategoriAktif === '') aria-current="page" @endif class="inline-flex min-h-9 items-center rounded-full border px-3.5 text-sm font-medium transition-colors {{ $kategoriAktif === '' ? 'border-hospital bg-hospital text-white' : 'border-[#BBD6E5] bg-white text-hospital-deep hover:bg-sage' }}">Semua topik</a>
                    @foreach ($kategoris as $kategori)
                        <a href="{{ route('public.videos.index', array_filter(['kategori' => $kategori, 'q' => $search === '' ? null : $search])) }}" @if ($kategoriAktif === $kategori) aria-current="page" @endif class="inline-flex min-h-9 items-center rounded-full border px-3.5 text-sm font-medium transition-colors {{ $kategoriAktif === $kategori ? 'border-hospital bg-hospital text-white' : 'border-[#BBD6E5] bg-white text-hospital-deep hover:bg-sage' }}">{{ $kategori }}</a>
                    @endforeach
                </nav>
            @endif
        </div>

        <div class="mt-9 flex flex-wrap items-baseline justify-between gap-2 border-l-4 border-hospital pl-4">
            <h2 class="text-xl font-medium tracking-tight text-hospital-deep sm:text-2xl">
                {{ $kategoriAktif === '' ? 'Semua video edukasi' : $kategoriAktif }}
            </h2>
            <p class="text-sm text-[#52697B]">{{ $videos->count() }} video</p>
        </div>

        @if ($videos->isEmpty())
            <div class="mt-6 rounded-2xl border border-[#D7E8F1] bg-white px-5 py-10 text-center">
                <div aria-hidden="true" class="mx-auto mb-3 flex size-11 items-center justify-center rounded-xl bg-sage text-hospital">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="size-5"><circle cx="11" cy="11" r="7" /><path d="m20 20-3.2-3.2" /></svg>
                </div>
                <p class="text-base font-medium text-hospital-deep">Belum ada video yang cocok dengan pencarianmu.</p>
                <a href="{{ route('public.videos.index') }}" class="mt-4 inline-flex min-h-11 items-center rounded-xl bg-hospital px-4 text-sm font-semibold text-white hover:bg-hospital-deep">Lihat semua video</a>
            </div>
        @else
            <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($videos as $video)
                    <article class="group flex flex-col overflow-hidden rounded-2xl border border-[#D7E8F1] bg-white shadow-[0_2px_10px_rgb(21_83_125_/_6%)] transition duration-200 hover:-translate-y-0.5 hover:border-[#B6D8E8] hover:shadow-[0_14px_30px_rgb(21_83_125_/_13%)]">
                        <a href="{{ route('public.videos.show', $video) }}" class="relative block aspect-video overflow-hidden bg-[#0C2E45]" aria-label="Tonton {{ $video->judul }}">
                            <img src="{{ $video->thumbnailUrl() }}" alt="Pratinjau video: {{ $video->judul }}" loading="lazy" class="size-full object-cover transition duration-300 group-hover:scale-[1.04]">
                            <span aria-hidden="true" class="absolute inset-0 bg-gradient-to-t from-[#061B2A]/70 via-[#061B2A]/10 to-transparent"></span>

                            <span class="absolute top-2.5 left-2.5 inline-flex max-w-[80%] items-center rounded-md bg-white/95 px-2 py-0.5 text-[11px] font-semibold text-hospital-deep">{{ $video->kategori }}</span>

                            <span aria-hidden="true" class="absolute inset-0 flex items-center justify-center">
                                <span class="flex size-12 items-center justify-center rounded-full bg-white/92 shadow-lg transition duration-200 group-hover:scale-110 group-hover:bg-white">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="ml-0.5 size-5 text-hospital"><path d="M8 5.14v13.72a1 1 0 0 0 1.55.83l10.2-6.86a1 1 0 0 0 0-1.66L9.55 4.31A1 1 0 0 0 8 5.14Z" /></svg>
                                </span>
                            </span>

                            @if ($video->durasi)
                                <span class="absolute right-2.5 bottom-2.5 rounded bg-[#061B2A]/85 px-1.5 py-0.5 text-[11px] font-medium text-white">{{ $video->durasi }}</span>
                            @endif
                        </a>

                        <div class="flex flex-1 flex-col p-4">
                            <h3 class="text-[0.95rem] font-semibold leading-snug text-hospital-deep">
                                <a href="{{ route('public.videos.show', $video) }}" class="transition-colors hover:text-hospital focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">{{ $video->judul }}</a>
                            </h3>
                            @if ($video->pembicara)
                                <p class="mt-2 flex items-start gap-1.5 text-sm leading-snug text-[#52697B]">
                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="mt-0.5 size-4 shrink-0"><circle cx="12" cy="8" r="3.5" /><path d="M5 20a7 7 0 0 1 14 0" /></svg>
                                    <span class="min-w-0">{{ $video->pembicara }}</span>
                                </p>
                            @endif
                            <div class="mt-auto pt-4">
                                <a href="{{ route('public.videos.show', $video) }}" class="inline-flex min-h-9 items-center gap-1 rounded-lg text-sm font-semibold text-hospital transition-colors hover:text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                                    Tonton video
                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="size-4"><path d="m9 6 6 6-6 6" /></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <div class="mt-10 rounded-2xl border border-[#D7E8F1] bg-white p-5 sm:p-6">
            <h2 class="text-base font-semibold text-hospital-deep">Cara menonton</h2>
            <ul class="mt-3 grid gap-3 text-sm leading-relaxed text-[#3E5768] sm:grid-cols-3">
                <li class="flex gap-2"><span class="font-semibold text-hospital">1.</span> Pilih topik atau gunakan kolom pencarian.</li>
                <li class="flex gap-2"><span class="font-semibold text-hospital">2.</span> Klik kartu video untuk membuka pemutar.</li>
                <li class="flex gap-2"><span class="font-semibold text-hospital">3.</span> Video diputar langsung di halaman ini, tanpa perlu keluar aplikasi.</li>
            </ul>
        </div>
    </section>
@endsection
