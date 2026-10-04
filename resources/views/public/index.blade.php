@extends('layouts.public', ['publicPageType' => 'list'])

@section('content')
    <div class="public-hero px-5 pb-24 pt-14 text-white sm:px-8 sm:pb-28 sm:pt-16 lg:pb-32 lg:pt-18">
        <div class="mx-auto max-w-4xl text-center">
            <h1 class="text-[2.5rem] font-bold leading-[1.12] tracking-tight sm:text-5xl lg:text-[3.5rem]">FAQ Hemodialisis</h1>
            <p class="mx-auto mt-4 max-w-2xl text-lg leading-relaxed text-[#E8F8FF] sm:text-xl">Temukan informasi umum seputar hemodialisis.</p>
        </div>
    </div>

    @if ($faqs->isNotEmpty())
        <section class="mx-auto max-w-5xl px-5 pb-18 sm:px-8 sm:pb-24" aria-label="Cari dan baca pertanyaan" data-public-faq-list>
            <div class="faq-search-shell relative -mt-13 rounded-2xl border border-[#D8E9F2] bg-white p-5 sm:-mt-14 sm:p-7">
                <label for="faq-search" class="mb-3 block text-base font-bold text-hospital-deep">Cari pertanyaan</label>
                <div class="relative">
                    <input id="faq-search" type="search" placeholder="Cari informasi hemodialisis...." autocomplete="off" data-faq-search class="min-h-15 w-full rounded-xl border border-[#6E899A] bg-white px-5 py-4 text-lg text-ink placeholder:text-[#5B7080] focus:border-hospital focus:outline-3 focus:outline-offset-2 focus:outline-hospital sm:pr-42">
                    <button type="button" hidden data-search-clear class="ui-press mt-3 min-h-12 rounded-lg px-4 text-sm font-bold whitespace-nowrap text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital sm:absolute sm:inset-y-1 sm:right-1 sm:mt-0">
                        Hapus pencarian
                    </button>
                </div>
            </div>

            <div class="mt-13 sm:mt-16">
                <div class="mb-5 border-l-4 border-hospital pl-4 sm:mb-7">
                    <h2 class="text-2xl font-bold tracking-tight text-hospital-deep sm:text-[1.75rem]">Pertanyaan yang sering diajukan</h2>
                </div>

                <div class="space-y-3 sm:space-y-4" data-faq-items>
                    @foreach ($faqs as $faq)
                        <article class="faq-public-item overflow-hidden rounded-2xl border border-[#D7E8F1] bg-white" data-faq-item>
                            <h3>
                                <button type="button" aria-expanded="false" aria-controls="faq-answer-{{ $faq->id }}" data-faq-toggle class="flex min-h-20 w-full items-center justify-between gap-5 px-5 py-5 text-left text-lg font-semibold leading-snug text-ink transition-colors hover:bg-[#F3FAFD] focus-visible:relative focus-visible:outline-3 focus-visible:-outline-offset-3 focus-visible:outline-hospital sm:min-h-23 sm:px-7 sm:py-6 sm:text-[1.3rem]">
                                    <span data-faq-question>{{ $faq->question }}</span>
                                    <span aria-hidden="true" data-faq-indicator class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-sage text-2xl font-normal leading-none text-hospital-deep transition-colors">+</span>
                                </button>
                            </h3>
                            <div id="faq-answer-{{ $faq->id }}" hidden data-faq-panel class="border-t border-[#DAEBF4] px-5 pb-7 pt-6 sm:px-7 sm:pb-8">
                                <p data-faq-short-answer class="max-w-[75ch] whitespace-pre-line text-base leading-[1.75] text-ink sm:text-lg">{{ $faq->short_answer }}</p>
                                @if ($faq->has_full_answer)
                                    <a href="{{ route('public.faq.show', $faq->slug) }}" class="ui-press mt-6 inline-flex min-h-12 items-center rounded-xl bg-hospital px-5 py-3 text-base font-semibold whitespace-nowrap text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                                        Lihat Selengkapnya
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div hidden data-faq-no-results class="rounded-2xl border border-[#D7E8F1] bg-white px-6 py-12 text-center sm:px-8 sm:py-16">
                    <div aria-hidden="true" class="mx-auto mb-5 flex size-16 items-center justify-center rounded-2xl bg-sage text-3xl font-light text-hospital">?</div>
                    <p class="mx-auto max-w-lg text-xl font-semibold leading-relaxed text-hospital-deep">Tidak ada pertanyaan yang sesuai. Coba kata kunci lain.</p>
                    <button type="button" data-empty-search-clear class="ui-press mt-6 min-h-12 rounded-xl bg-hospital px-5 py-3 font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                        Hapus pencarian
                    </button>
                </div>
            </div>
        </section>
    @else
        <div class="mx-auto max-w-5xl px-5 pb-20 sm:px-8">
            <div class="faq-search-shell relative -mt-12 rounded-2xl border border-[#D7E8F1] bg-white px-6 py-12 text-center sm:px-8 sm:py-16">
                <p class="text-lg font-semibold leading-relaxed text-hospital-deep">Informasi belum tersedia. Silakan hubungi petugas.</p>
            </div>
        </div>
    @endif
@endsection
