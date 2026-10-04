<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle ?? 'FAQ Hemodialisis' }} | {{ config('hospital.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body data-public-page data-public-page-type="{{ $publicPageType ?? 'detail' }}" data-public-index-url="{{ route('public.index') }}" class="min-h-dvh bg-paper font-sans text-ink antialiased">
        <a href="#konten-utama" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-xl focus:bg-hospital focus:px-4 focus:py-3 focus:font-semibold focus:text-white">Lewati ke konten utama</a>
        <div class="flex min-h-dvh flex-col">
            <header class="relative z-10 border-b border-[#DAE8F0] bg-white">
                <div class="mx-auto flex min-h-19 w-full max-w-7xl items-center px-5 sm:px-8 lg:px-12">
                    <a href="{{ route('public.index') }}" class="flex min-w-0 items-center gap-3 rounded-lg focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-hospital sm:gap-4">
                        <img src="{{ asset('images/rsud-m-yunus-logo.png') }}" alt="Logo resmi RSUD Dr. M. Yunus Bengkulu" width="54" height="54" class="size-12 shrink-0 object-contain sm:size-14">
                        <span class="min-w-0 leading-tight">
                            <span class="block text-sm font-bold tracking-tight text-hospital-deep sm:text-base">{{ config('hospital.name') }}</span>
                            <span class="mt-0.5 block text-xs font-medium tracking-[0.04em] text-[#527085] sm:text-sm">FAQ Hemodialisis</span>
                        </span>
                    </a>
                </div>
            </header>

            <main class="w-full flex-1" id="konten-utama">
                @yield('content')
            </main>

            @include('public.footer')
        </div>
    </body>
</html>
