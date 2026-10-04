<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Masuk Admin | FAQ Hemodialisis</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-dvh bg-paper font-sans text-ink antialiased">
        <header class="border-b border-[#D8E6EF] bg-white">
            <div class="mx-auto flex min-h-16 w-full max-w-5xl items-center gap-2.5 px-5 sm:px-8">
                <img src="{{ asset('images/rsud-m-yunus-logo.png') }}" alt="Logo resmi RSUD Dr. M. Yunus Bengkulu" width="42" height="42" class="size-10.5 shrink-0 object-contain">
                <span class="leading-tight">
                    <span class="block text-sm font-semibold tracking-tight text-hospital-deep">RSUD Dr. M. Yunus Bengkulu</span>
                    <span class="mt-0.5 block text-xs font-medium text-[#547186]">FAQ Hemodialisis</span>
                </span>
            </div>
        </header>

        <main class="mx-auto grid min-h-[calc(100dvh-64px)] w-full max-w-5xl items-center px-5 py-6 sm:px-8 sm:py-8">
            <div class="admin-panel mx-auto grid w-full max-w-4xl overflow-hidden rounded-2xl border border-[#D6E5EE] bg-white lg:grid-cols-[1.02fr_0.98fr]">
                <div class="relative min-h-40 overflow-hidden bg-[#D8E6EF] sm:min-h-52 lg:min-h-[430px]">
                    <img src="{{ asset('images/rsud-m-yunus-building.jpg') }}" alt="Gedung RSUD Dr. M. Yunus Bengkulu" width="1000" height="600" class="absolute inset-0 size-full object-cover object-[70%_center] lg:object-[74%_center]">
                </div>
                <div class="self-center p-6 sm:p-8 lg:p-9">
                    <span class="mb-4 flex size-10 items-center justify-center rounded-lg bg-[#E8F2FF] text-hospital" aria-hidden="true"><span class="admin-icon admin-icon-lock"></span></span>
                    <h1 class="text-2xl font-semibold leading-tight tracking-tight text-hospital-deep">Masuk ke admin</h1>
                    <p class="mt-2 text-sm leading-relaxed text-[#52697B]">Kelola FAQ Hemodialisis.</p>

                <form action="{{ route('admin.login.store') }}" method="POST" data-admin-login-form class="mt-6">
                    @csrf

                    <div>
                        <label for="email" class="mb-1 block text-sm font-semibold">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required
                            autofocus
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            @if ($errors->has('email')) aria-describedby="email-error" @endif
                            class="min-h-11 w-full rounded-xl border border-[#6F8DA2] bg-white px-4 py-2 text-base text-ink outline-none transition-colors focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-[#E3F3FA]"
                        >
                        @error('email')
                            <p id="email-error" class="mt-2 text-sm font-medium text-[#A52D38]" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password" class="mb-1 block text-sm font-semibold">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                            @if ($errors->has('password')) aria-describedby="password-error" @endif
                            class="min-h-11 w-full rounded-xl border border-[#6F8DA2] bg-white px-4 py-2 text-base text-ink outline-none transition-colors focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-[#E3F3FA]"
                        >
                        @error('password')
                            <p id="password-error" class="mt-2 text-sm font-medium text-[#A52D38]" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" data-login-submit class="mt-6 min-h-11 w-full rounded-xl bg-hospital px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep disabled:cursor-wait disabled:opacity-80">
                        Masuk
                    </button>
                </form>
                </div>
            </div>
        </main>
    </body>
</html>
