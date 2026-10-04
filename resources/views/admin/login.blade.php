<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Masuk Admin | FAQ Hemodialisis</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-dvh bg-paper font-sans text-ink antialiased">
        <div class="h-1 bg-hospital" aria-hidden="true"></div>

        <header class="border-b border-[#DDE5DF] bg-white">
            <div class="mx-auto flex min-h-16 w-full max-w-6xl items-center px-5 sm:px-8">
                <span class="text-lg font-bold tracking-tight text-hospital-deep">RSUD Dr. M. Yunus Bengkulu</span>
            </div>
        </header>

        <main class="mx-auto grid min-h-[calc(100dvh-68px)] w-full max-w-6xl items-center px-5 py-6 sm:px-8">
            <div class="mx-auto w-full max-w-md">
                <div class="mb-5">
                    <h1 class="text-4xl font-bold leading-tight tracking-tight text-hospital-deep">Masuk ke admin</h1>
                    <p class="mt-2 text-base leading-relaxed text-[#52615B]">Masuk untuk mengelola FAQ Hemodialisis.</p>
                </div>

                <form action="{{ route('admin.login.store') }}" method="POST" data-admin-login-form class="rounded-2xl border border-[#D9E4DD] bg-white p-5 sm:p-6">
                    @csrf

                    <div>
                        <label for="email" class="mb-1 block text-base font-semibold">Email</label>
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
                            class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 py-2 text-base text-ink outline-none transition-colors focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-[#DDEDE7]"
                        >
                        @error('email')
                            <p id="email-error" class="mt-2 text-sm font-medium text-[#9B3028]" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password" class="mb-1 block text-base font-semibold">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                            @if ($errors->has('password')) aria-describedby="password-error" @endif
                            class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 py-2 text-base text-ink outline-none transition-colors focus-visible:border-hospital focus-visible:ring-4 focus-visible:ring-[#DDEDE7]"
                        >
                        @error('password')
                            <p id="password-error" class="mt-2 text-sm font-medium text-[#9B3028]" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" data-login-submit class="mt-6 min-h-12 w-full rounded-xl bg-hospital px-5 py-3 text-base font-bold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital-deep disabled:cursor-wait disabled:opacity-80">
                        Masuk
                    </button>
                </form>
            </div>
        </main>
    </body>
</html>
