<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ isset($pageTitle) ? $pageTitle.' | ' : '' }}{{ config('app.name') }} | {{ config('hospital.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body data-public-page data-public-page-type="{{ $publicPageType ?? 'detail' }}" data-public-index-url="{{ route('public.index') }}" class="min-h-dvh bg-paper font-sans text-ink antialiased">
        <a href="#konten-utama" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-xl focus:bg-hospital focus:px-4 focus:py-3 focus:font-semibold focus:text-white">Lewati ke konten utama</a>
        <div class="flex min-h-dvh flex-col">
            <header class="relative z-10 border-b border-[#DAE8F0] bg-white">
                <div class="public-header-inner mx-auto flex min-h-16 w-full max-w-7xl items-center justify-between gap-3 px-5 py-2 sm:px-8 lg:px-10">
                    <a href="{{ route('public.index') }}" class="flex min-w-0 items-center gap-2.5 rounded-lg focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-hospital sm:gap-3">
                        <img src="{{ asset('images/rsud-m-yunus-logo.png') }}" alt="Logo resmi RSUD Dr. M. Yunus Bengkulu" width="48" height="48" class="public-brand-logo size-10 shrink-0 object-contain sm:size-11">
                        <span class="min-w-0 leading-tight">
                            <span class="public-brand-name block text-sm font-semibold tracking-tight text-hospital-deep sm:text-base">{{ config('app.name') }}</span>
                            <span class="public-brand-subtitle mt-0.5 block text-[11px] leading-snug text-[#527085] sm:text-xs">{{ config('hospital.name') }}</span>
                        </span>
                    </a>
                    <div class="flex shrink-0 items-center gap-1.5 border-l border-[#D8E6EF] pl-2.5 sm:gap-3 sm:pl-4" aria-label="Logo mitra">
                        <img src="{{ asset('images/unib.png') }}" alt="Logo Universitas Bengkulu" width="40" height="40" class="public-partner-logo size-8 object-contain sm:size-10">
                        <img src="{{ asset('images/poltek.webp') }}" alt="Logo Poltekkes" width="40" height="40" class="institution-logo-poltek public-partner-logo size-8 object-contain sm:size-10">
                    </div>
                </div>
            </header>

            <main class="w-full flex-1" id="konten-utama">
                @yield('content')
            </main>

            @include('public.footer')
        </div>
    </body>
</html>
