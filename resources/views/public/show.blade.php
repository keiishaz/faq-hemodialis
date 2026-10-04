@extends('layouts.public')

@section('content')
    <a href="{{ route('public.index') }}" class="inline-flex min-h-12 items-center rounded-xl border border-[#627B6F] bg-white px-5 py-3 font-semibold text-hospital-deep transition-colors hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
        Kembali ke FAQ
    </a>

    <article class="mt-10 max-w-3xl sm:mt-12">
        <h1 class="text-3xl font-bold leading-tight tracking-tight text-hospital-deep sm:text-[2.5rem]">{{ $faq->question }}</h1>
        <div class="faq-content mt-8 border-t border-[#C6DED1] pt-7 text-lg leading-[1.8] text-ink sm:mt-10 sm:pt-8 sm:text-xl">
            {!! $fullAnswer !!}
        </div>
    </article>
@endsection
