<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Panel Admin') | FAQ Hemodialisis</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-dvh bg-paper font-sans text-ink antialiased">
        <div class="h-1 bg-hospital" aria-hidden="true"></div>

        <div class="min-h-[calc(100dvh-4px)] md:grid md:grid-cols-[250px_minmax(0,1fr)]">
            <aside class="hidden border-r border-[#DDE5DF] bg-white px-5 py-8 md:flex md:flex-col">
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold leading-snug tracking-tight text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                    RSUD Dr. M. Yunus Bengkulu
                </a>
                <p class="mt-2 text-sm text-[#5B6A63]">FAQ Hemodialisis</p>

                <nav aria-label="Navigasi admin" class="mt-12">
                    <a href="{{ route('admin.dashboard') }}" aria-current="page" class="flex min-h-12 items-center rounded-xl bg-sage px-4 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                        Dashboard
                    </a>
                </nav>
            </aside>

            <div class="min-w-0">
                <header class="border-b border-[#DDE5DF] bg-white">
                    <div class="mx-auto flex min-h-18 w-full max-w-6xl items-center justify-between gap-4 px-5 sm:px-8">
                        <a href="{{ route('admin.dashboard') }}" class="font-bold text-hospital-deep md:hidden">RSUD Dr. M. Yunus Bengkulu</a>
                        <span class="hidden text-sm font-medium text-[#5B6A63] md:block">Panel admin</span>

                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="min-h-12 rounded-xl border border-[#627B6F] bg-white px-4 font-semibold text-hospital-deep transition-colors hover:bg-sage focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                                Keluar
                            </button>
                        </form>
                    </div>
                </header>

                <main class="mx-auto w-full max-w-6xl px-5 py-10 sm:px-8 sm:py-14">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
