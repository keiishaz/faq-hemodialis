<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Panel Admin') | {{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-dvh bg-paper font-sans text-ink antialiased">
        <a href="#konten-utama" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-xl focus:bg-hospital focus:px-4 focus:py-3 focus:font-semibold focus:text-white">Lewati ke konten utama</a>
        <div class="min-h-dvh md:grid md:grid-cols-[216px_minmax(0,1fr)]">
            <aside class="hidden border-r border-[#D8E6EF] bg-white px-4 py-5 md:sticky md:top-0 md:flex md:h-dvh md:flex-col">
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital">
                    <span class="flex items-center gap-2.5">
                        <span class="flex size-11 items-center justify-center">
                            <img src="{{ asset('images/rsud-m-yunus-logo.png') }}" alt="Logo resmi RSUD Dr. M. Yunus Bengkulu" width="36" height="36" class="size-9 object-contain">
                        </span>
                        <span class="flex size-11 items-center justify-center">
                            <img src="{{ asset('images/unib.png') }}" alt="Logo Universitas Bengkulu" width="44" height="44" class="size-11 object-contain">
                        </span>
                        <span class="flex size-11 items-center justify-center">
                            <img src="{{ asset('images/poltek.webp') }}" alt="Logo Poltekkes" width="44" height="44" class="institution-logo-poltek size-11 object-contain">
                        </span>
                    </span>
                    <span class="mt-2 block text-sm font-semibold leading-snug tracking-tight text-hospital-deep">{{ config('app.name') }}</span>
                    <span class="mt-1 block text-xs leading-snug text-[#547186]">{{ config('hospital.name') }}</span>
                </a>

                <p class="mt-7 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#547186]">Ruang admin</p>
                <nav aria-label="Navigasi admin" class="mt-3 space-y-1 text-sm">
                    <a href="{{ route('admin.dashboard') }}" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif class="admin-nav-link flex min-h-11 items-center gap-2.5 rounded-lg px-3 font-medium text-[#52697B] focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital {{ request()->routeIs('admin.dashboard') ? 'bg-[#E8F2FF] font-semibold' : 'hover:bg-sage' }}">
                        <span class="admin-icon admin-icon-dashboard" aria-hidden="true"></span>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.faqs.index') }}" @if (request()->routeIs('admin.faqs.*')) aria-current="page" @endif class="admin-nav-link flex min-h-11 items-center gap-2.5 rounded-lg px-3 font-medium text-[#52697B] focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital {{ request()->routeIs('admin.faqs.*') ? 'bg-[#E8F2FF] font-semibold' : 'hover:bg-sage' }}">
                        <span class="admin-icon admin-icon-faq" aria-hidden="true"></span>
                        FAQ
                    </a>
                    <a href="{{ route('admin.profile.edit') }}" @if (request()->routeIs('admin.profile.*')) aria-current="page" @endif class="admin-nav-link flex min-h-11 items-center gap-2.5 rounded-lg px-3 font-medium text-[#52697B] focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital {{ request()->routeIs('admin.profile.*') ? 'bg-[#E8F2FF] font-semibold' : 'hover:bg-sage' }}">
                        <span class="admin-icon admin-icon-profile" aria-hidden="true"></span>
                        Profil
                    </a>
                </nav>

                <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto border-t border-[#D8E6EF] pt-4">
                    @csrf
                    <button type="submit" class="flex min-h-11 w-full items-center gap-2.5 rounded-lg px-3 text-left text-sm font-medium text-[#B42335] transition-colors hover:bg-[#FFF0F1] focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-[#B42335]"><span class="admin-icon admin-icon-logout" aria-hidden="true"></span>Keluar</button>
                </form>
            </aside>

            <div class="min-w-0">
                <header class="border-b border-[#D8E6EF] bg-white">
                    <div class="mx-auto flex min-h-16 w-full max-w-[1440px] items-center justify-between gap-2 px-5 sm:px-7 lg:gap-4 lg:px-8">
                        <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 items-center gap-2 text-hospital-deep md:hidden">
                            <img src="{{ asset('images/rsud-m-yunus-logo.png') }}" alt="Logo resmi RSUD Dr. M. Yunus Bengkulu" width="36" height="36" class="size-9 shrink-0 object-contain">
                            <span class="min-w-0 leading-tight">
                                <span class="block text-sm font-semibold">{{ config('app.name') }}</span>
                                <span class="block text-[10px] text-[#547186] sm:text-xs">{{ config('hospital.name') }}</span>
                            </span>
                        </a>
                        <div class="flex shrink-0 items-center gap-1 md:hidden" aria-label="Logo mitra">
                            <img src="{{ asset('images/unib.png') }}" alt="Logo Universitas Bengkulu" width="28" height="28" class="size-7 object-contain">
                            <img src="{{ asset('images/poltek.webp') }}" alt="Logo Poltekkes" width="28" height="28" class="institution-logo-poltek size-7 object-contain">
                        </div>
                        <div class="hidden items-center gap-3 text-sm md:flex">
                            <span class="text-[#547186]">Ruang admin</span>
                            <span aria-hidden="true" class="text-[#7E9AAE]">›</span>
                            <span class="font-semibold text-hospital-deep">{{ request()->routeIs('admin.dashboard') ? 'Dashboard' : (request()->routeIs('admin.profile.*') ? 'Profil' : 'FAQ') }}</span>
                        </div>
                        <div class="hidden items-center gap-3 md:flex">
                            <span aria-hidden="true" class="flex size-8 items-center justify-center rounded-full bg-sage text-xs font-semibold text-hospital">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="max-w-48 truncate text-sm font-medium text-hospital-deep">{{ auth()->user()->name }}</span>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST" class="md:hidden">
                            @csrf
                            <button type="submit" aria-label="Keluar" class="flex min-h-11 min-w-11 items-center justify-center gap-2 rounded-xl border border-[#D58B87] bg-white px-2 font-medium text-[#B42335] transition-colors hover:bg-[#FFF0F1] focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-[#B42335] sm:px-3">
                                <span class="admin-icon admin-icon-logout" aria-hidden="true"></span><span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                </header>

                <details class="group border-b border-[#D8E6EF] bg-white px-5 py-2 md:hidden">
                    <summary class="flex min-h-12 cursor-pointer items-center justify-between rounded-xl px-3 font-semibold text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                        Menu admin
                        <span aria-hidden="true" class="text-xl group-open:hidden">+</span>
                        <span aria-hidden="true" class="hidden text-xl group-open:inline">-</span>
                    </summary>
                    <nav aria-label="Navigasi admin mobile" class="grid gap-1 pb-2 pt-1">
                        <a href="{{ route('admin.dashboard') }}" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif class="flex min-h-12 items-center gap-3 rounded-xl px-4 font-medium text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital {{ request()->routeIs('admin.dashboard') ? 'bg-sage' : 'hover:bg-sage' }}"><span class="admin-icon admin-icon-dashboard" aria-hidden="true"></span>Dashboard</a>
                        <a href="{{ route('admin.faqs.index') }}" @if (request()->routeIs('admin.faqs.*')) aria-current="page" @endif class="flex min-h-12 items-center gap-3 rounded-xl px-4 font-medium text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital {{ request()->routeIs('admin.faqs.*') ? 'bg-sage' : 'hover:bg-sage' }}"><span class="admin-icon admin-icon-faq" aria-hidden="true"></span>FAQ</a>
                        <a href="{{ route('admin.profile.edit') }}" @if (request()->routeIs('admin.profile.*')) aria-current="page" @endif class="flex min-h-12 items-center gap-3 rounded-xl px-4 font-medium text-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital {{ request()->routeIs('admin.profile.*') ? 'bg-sage' : 'hover:bg-sage' }}"><span class="admin-icon admin-icon-profile" aria-hidden="true"></span>Profil</a>
                    </nav>
                </details>

                <main id="konten-utama" class="mx-auto w-full max-w-[1440px] px-5 py-7 sm:px-7 sm:py-8 lg:px-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
