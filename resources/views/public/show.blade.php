@extends('layouts.public')

@section('content')
    <div class="public-hero public-hero-detail px-5 pb-16 pt-8 text-white sm:px-8 sm:pb-20 sm:pt-10">
        <div class="public-faq-container public-hero-copy mx-auto max-w-4xl">
            <a href="{{ route('public.index') }}" class="ui-press inline-flex min-h-11 items-center rounded-xl border border-white/70 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-white/15 focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-white">
                Kembali ke FAQ
            </a>
            <h1 class="public-detail-title mt-6 max-w-4xl text-2xl font-semibold leading-tight tracking-tight sm:text-[2rem]">{{ $faq->question }}</h1>
        </div>
    </div>

    <div class="public-faq-container mx-auto max-w-4xl px-5 pb-16 sm:px-8 sm:pb-20">
        <article class="admin-panel relative -mt-8 rounded-2xl border border-[#D7E8F1] bg-white p-5 sm:-mt-10 sm:p-8">
            <div class="faq-content public-detail-content max-w-3xl text-base leading-[1.75] text-ink sm:text-lg">
                {!! $fullAnswer !!}
            </div>
        </article>
    </div>
@endsection
