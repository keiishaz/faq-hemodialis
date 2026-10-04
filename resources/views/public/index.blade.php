@extends('layouts.public', ['publicPageType' => 'list'])

@section('content')
    <div class="public-hero public-hero-home px-5 pb-20 pt-11 text-white sm:px-8 sm:pb-22 sm:pt-12">
        <div class="public-hero-copy mx-auto max-w-4xl text-center">
            <h1 class="public-hero-title text-[2rem] font-semibold leading-[1.15] tracking-tight sm:text-[2.5rem]">FAQ Hemodialisis</h1>
            <p class="public-hero-subtitle mx-auto mt-3 max-w-2xl text-base leading-relaxed text-[#E8F8FF] sm:text-lg">Temukan informasi umum seputar hemodialisis.</p>
        </div>
    </div>

    @if ($faqs->isNotEmpty())
        <section class="public-faq-container mx-auto max-w-4xl px-5 pb-16 sm:px-8 sm:pb-20" aria-label="Cari dan baca pertanyaan" data-public-faq-list>
            <div class="faq-search-shell relative -mt-10 rounded-2xl border border-[#D8E9F2] bg-white p-5 sm:-mt-11 sm:p-6">
                <label for="faq-search" class="public-search-label mb-2 block text-sm font-semibold text-hospital-deep">Cari pertanyaan</label>
                <div class="relative">
                    <input id="faq-search" type="search" placeholder="Cari informasi hemodialisis...." autocomplete="off" data-faq-search class="public-search-input min-h-12 w-full rounded-xl border border-[#6E899A] bg-white py-3 pl-4 pr-14 text-base text-ink placeholder:text-[#5B7080] focus:border-hospital focus:outline-3 focus:outline-offset-2 focus:outline-hospital">
                    <button type="button" hidden data-search-clear aria-label="Hapus pencarian" title="Hapus pencarian" class="absolute top-1/2 right-1 flex size-11 -translate-y-1/2 items-center justify-center rounded-lg text-hospital-deep transition-colors hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="size-5"><path d="M6 6l12 12M18 6L6 18" /></svg>
                    </button>
                </div>
            </div>

            <div class="mt-10 sm:mt-12">
                <div class="mb-4 border-l-4 border-hospital pl-4 sm:mb-5">
                    <h2 class="public-list-title text-xl font-medium tracking-tight text-hospital-deep sm:text-2xl">Pertanyaan yang sering diajukan</h2>
                </div>

                <div class="overflow-hidden rounded-2xl border border-[#D7E8F1] bg-white" data-faq-items>
                    @foreach ($faqs as $faq)
                        <article class="faq-public-item border-b border-[#E1ECF2] last:border-b-0" data-faq-item>
                            <h3>
                                <button type="button" aria-expanded="false" aria-controls="faq-answer-{{ $faq->id }}" data-faq-toggle class="public-faq-toggle flex min-h-16 w-full items-center gap-2.5 px-5 py-4 text-left text-base font-semibold leading-snug text-ink transition-colors hover:bg-[#F3FAFD] focus-visible:relative focus-visible:z-10 focus-visible:outline-3 focus-visible:-outline-offset-3 focus-visible:outline-hospital sm:gap-4 sm:px-6">
                                    <span data-faq-icon aria-hidden="true" class="flex size-7 shrink-0 items-center justify-center rounded-lg bg-[#EAF4F8] text-base font-semibold text-hospital sm:size-8">?</span>
                                    <span data-faq-question class="min-w-0 flex-1">{{ $faq->question }}</span>
                                    <span aria-hidden="true" data-faq-indicator class="flex size-9 shrink-0 items-center justify-center rounded-full border border-[#B6D8E8] bg-[#F5FAFC] text-xl font-normal leading-none text-hospital-deep transition-colors">+</span>
                                </button>
                            </h3>
                            <div id="faq-answer-{{ $faq->id }}" hidden data-faq-panel class="border-t border-[#DAEBF4] px-5 pb-5 pt-4 sm:px-6 sm:pb-6">
                                <p data-faq-short-answer class="max-w-[75ch] whitespace-pre-line text-sm leading-[1.7] text-ink sm:text-base">{{ $faq->short_answer }}</p>
                                @if ($faq->has_full_answer)
                                    <a href="{{ route('public.faq.show', $faq->slug) }}" class="ui-press mt-5 inline-flex min-h-11 items-center rounded-xl bg-hospital px-4 py-2 text-sm font-semibold whitespace-nowrap text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                                        Lihat Selengkapnya
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div hidden data-faq-no-results class="rounded-2xl border border-[#D7E8F1] bg-white px-5 py-6 text-center sm:flex sm:items-center sm:gap-4 sm:px-6 sm:py-5 sm:text-left">
                    <div aria-hidden="true" class="mx-auto mb-3 flex size-10 items-center justify-center rounded-lg bg-sage text-lg font-medium text-hospital sm:mx-0 sm:mb-0 sm:shrink-0">?</div>
                    <p class="text-base font-medium leading-relaxed text-hospital-deep">Tidak ada pertanyaan yang sesuai. Coba kata kunci lain.</p>
                </div>
            </div>
        </section>
    @else
        <div class="public-faq-container mx-auto max-w-4xl px-5 pb-16 sm:px-8">
            <div class="faq-search-shell relative -mt-10 rounded-2xl border border-[#D7E8F1] bg-white px-5 py-8 text-center sm:px-8">
                <p class="text-base font-medium leading-relaxed text-hospital-deep">Informasi belum tersedia. Silakan hubungi petugas.</p>
            </div>
        </div>
    @endif
@endsection
