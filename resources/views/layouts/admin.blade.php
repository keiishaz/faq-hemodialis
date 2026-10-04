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
                    <a href="{{ route('admin.dashboard') }}" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif class="flex min-h-12 items-center rounded-xl px-4 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital {{ request()->routeIs('admin.dashboard') ? 'bg-sage' : 'hover:bg-sage' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.faqs.index') }}" @if (request()->routeIs('admin.faqs.*')) aria-current="page" @endif class="mt-2 flex min-h-12 items-center rounded-xl px-4 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital {{ request()->routeIs('admin.faqs.*') ? 'bg-sage' : 'hover:bg-sage' }}">
                        FAQ
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

                <nav aria-label="Navigasi admin mobile" class="flex gap-2 border-b border-[#DDE5DF] bg-white px-5 py-2 md:hidden">
                    <a href="{{ route('admin.dashboard') }}" class="min-h-11 rounded-lg px-4 py-3 text-sm font-semibold text-hospital-deep {{ request()->routeIs('admin.dashboard') ? 'bg-sage' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.faqs.index') }}" class="min-h-11 rounded-lg px-4 py-3 text-sm font-semibold text-hospital-deep {{ request()->routeIs('admin.faqs.*') ? 'bg-sage' : '' }}">FAQ</a>
                </nav>

                <main class="mx-auto w-full max-w-6xl px-5 py-10 sm:px-8 sm:py-14">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
