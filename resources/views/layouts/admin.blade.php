<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Panel Admin') | FAQ Hemodialisis</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-dvh bg-paper font-sans text-ink antialiased">
        <a href="#konten-utama" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-xl focus:bg-hospital focus:px-4 focus:py-3 focus:font-semibold focus:text-white">Lewati ke konten utama</a>
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
                    <a href="{{ route('admin.profile.edit') }}" @if (request()->routeIs('admin.profile.*')) aria-current="page" @endif class="mt-2 flex min-h-12 items-center rounded-xl px-4 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital {{ request()->routeIs('admin.profile.*') ? 'bg-sage' : 'hover:bg-sage' }}">
                        Profil
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

                <details class="group border-b border-[#DDE5DF] bg-white px-5 py-2 md:hidden">
                    <summary class="flex min-h-12 cursor-pointer items-center justify-between rounded-xl px-3 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                        Menu admin
                        <span aria-hidden="true" class="text-xl group-open:hidden">+</span>
                        <span aria-hidden="true" class="hidden text-xl group-open:inline">-</span>
                    </summary>
                    <nav aria-label="Navigasi admin mobile" class="grid gap-1 pb-2 pt-1">
                        <a href="{{ route('admin.dashboard') }}" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif class="flex min-h-12 items-center rounded-xl px-4 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital {{ request()->routeIs('admin.dashboard') ? 'bg-sage' : 'hover:bg-sage' }}">Dashboard</a>
                        <a href="{{ route('admin.faqs.index') }}" @if (request()->routeIs('admin.faqs.*')) aria-current="page" @endif class="flex min-h-12 items-center rounded-xl px-4 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital {{ request()->routeIs('admin.faqs.*') ? 'bg-sage' : 'hover:bg-sage' }}">FAQ</a>
                        <a href="{{ route('admin.profile.edit') }}" @if (request()->routeIs('admin.profile.*')) aria-current="page" @endif class="flex min-h-12 items-center rounded-xl px-4 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital {{ request()->routeIs('admin.profile.*') ? 'bg-sage' : 'hover:bg-sage' }}">Profil</a>
                    </nav>
                </details>

                <main id="konten-utama" class="mx-auto w-full max-w-6xl px-5 py-10 sm:px-8 sm:py-14">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
