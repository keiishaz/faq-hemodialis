@extends('layouts.public')

@section('content')
    <div class="public-hero px-5 pb-20 pt-10 text-white sm:px-8 sm:pb-24 sm:pt-12">
        <div class="mx-auto max-w-5xl">
            <a href="{{ route('public.index') }}" class="ui-press inline-flex min-h-12 items-center rounded-xl border border-white/70 px-5 py-3 font-semibold text-white transition-colors hover:bg-white/15 focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-white">
                Kembali ke FAQ
            </a>
            <h1 class="mt-7 max-w-4xl text-3xl font-bold leading-tight tracking-tight sm:text-[2.5rem]">{{ $faq->question }}</h1>
        </div>
    </div>

    <div class="mx-auto max-w-5xl px-5 pb-20 sm:px-8 sm:pb-24">
        <article class="admin-panel relative -mt-10 rounded-2xl border border-[#D7E8F1] bg-white p-6 sm:-mt-12 sm:p-10">
            <div class="faq-content max-w-3xl text-lg leading-[1.8] text-ink sm:text-xl">
                {!! $fullAnswer !!}
            </div>
        </article>
    </div>
@endsection
