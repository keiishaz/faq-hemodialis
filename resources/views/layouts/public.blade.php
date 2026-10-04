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
        <div class="h-1 bg-hospital" aria-hidden="true"></div>
        <div class="flex min-h-[calc(100dvh-4px)] flex-col">
            <header class="border-b border-[#DDE5DF] bg-white">
                <div class="mx-auto flex min-h-20 w-full max-w-5xl items-center px-5 sm:px-8">
                    <a href="{{ route('public.index') }}" class="max-w-[18rem] text-base font-bold leading-snug tracking-tight text-hospital-deep focus-visible:rounded-sm focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-hospital sm:max-w-none sm:text-lg">
                        {{ config('hospital.name') }}
                    </a>
                </div>
            </header>

            <main class="mx-auto w-full max-w-5xl flex-1 px-5 pb-16 pt-10 sm:px-8 sm:pb-20 sm:pt-14 lg:pt-16" id="konten-utama">
                @yield('content')
            </main>

            @include('public.footer')
        </div>
    </body>
</html>
