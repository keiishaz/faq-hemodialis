@extends('layouts.admin')

@section('title', 'Profil')

@section('content')
    <div class="max-w-3xl">
        <h1 class="text-3xl font-bold leading-tight tracking-tight text-hospital-deep sm:text-4xl">Profil admin</h1>
        <p class="mt-3 text-base leading-relaxed text-[#52615B]">Perbarui nama dan email akun, atau ubah password secara terpisah.</p>

        <section aria-labelledby="profile-details-title" class="mt-8 rounded-2xl border border-[#D9E4DD] bg-white p-5 sm:p-8">
            <h2 id="profile-details-title" class="text-xl font-bold tracking-tight text-hospital-deep sm:text-2xl">Informasi akun</h2>
            <p class="mt-2 text-sm leading-relaxed text-[#52615B]">Password saat ini hanya diperlukan saat email diubah.</p>

            @if (session('profile_status'))
                <p role="status" class="mt-5 rounded-xl border border-[#A9D1BE] bg-sage px-4 py-3 font-medium text-hospital-deep">{{ session('profile_status') }}</p>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST" class="mt-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="profile-name" class="mb-2 block font-semibold text-ink">Nama</label>
                    <input id="profile-name" name="name" type="text" autocomplete="name" maxlength="100" required value="{{ old('name', $user->name) }}" aria-invalid="{{ $errors->profile->has('name') ? 'true' : 'false' }}" @if ($errors->profile->has('name')) aria-describedby="profile-name-error" @endif class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('name', 'profile') <p id="profile-name-error" role="alert" class="mt-2 text-sm font-medium text-[#9B3028]">{{ $message }}</p> @enderror
                </div>

                <div class="mt-6">
                    <label for="profile-email" class="mb-2 block font-semibold text-ink">Email</label>
                    <input id="profile-email" name="email" type="email" autocomplete="email" maxlength="255" required value="{{ old('email', $user->email) }}" aria-invalid="{{ $errors->profile->has('email') ? 'true' : 'false' }}" @if ($errors->profile->has('email')) aria-describedby="profile-email-error" @endif class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('email', 'profile') <p id="profile-email-error" role="alert" class="mt-2 text-sm font-medium text-[#9B3028]">{{ $message }}</p> @enderror
                </div>

                <div class="mt-6">
                    <label for="profile-current-password" class="mb-2 block font-semibold text-ink">Password saat ini <span class="font-normal text-[#52615B]">(jika email diubah)</span></label>
                    <input id="profile-current-password" name="current_password" type="password" autocomplete="current-password" aria-invalid="{{ $errors->profile->has('current_password') ? 'true' : 'false' }}" @if ($errors->profile->has('current_password')) aria-describedby="profile-current-password-error" @endif class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('current_password', 'profile') <p id="profile-current-password-error" role="alert" class="mt-2 text-sm font-medium text-[#9B3028]">{{ $message }}</p> @enderror
                </div>

                <div class="mt-8 border-t border-[#D9E4DD] pt-6 sm:text-right">
                    <button type="submit" class="min-h-12 w-full rounded-xl bg-hospital px-6 font-bold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital sm:w-auto">Simpan profil</button>
                </div>
            </form>
        </section>

        <section aria-labelledby="profile-password-title" class="mt-7 rounded-2xl border border-[#D9E4DD] bg-white p-5 sm:p-8">
            <h2 id="profile-password-title" class="text-xl font-bold tracking-tight text-hospital-deep sm:text-2xl">Ubah password</h2>
            <p class="mt-2 text-sm leading-relaxed text-[#52615B]">Gunakan password baru minimal 12 karakter.</p>

            @if (session('password_status'))
                <p role="status" class="mt-5 rounded-xl border border-[#A9D1BE] bg-sage px-4 py-3 font-medium text-hospital-deep">{{ session('password_status') }}</p>
            @endif

            <form action="{{ route('admin.profile.password') }}" method="POST" class="mt-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="password-current" class="mb-2 block font-semibold text-ink">Password saat ini</label>
                    <input id="password-current" name="current_password" type="password" autocomplete="current-password" required aria-invalid="{{ $errors->password->has('current_password') ? 'true' : 'false' }}" @if ($errors->password->has('current_password')) aria-describedby="password-current-error" @endif class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('current_password', 'password') <p id="password-current-error" role="alert" class="mt-2 text-sm font-medium text-[#9B3028]">{{ $message }}</p> @enderror
                </div>

                <div class="mt-6">
                    <label for="password-new" class="mb-2 block font-semibold text-ink">Password baru</label>
                    <input id="password-new" name="password" type="password" autocomplete="new-password" minlength="12" required aria-invalid="{{ $errors->password->has('password') ? 'true' : 'false' }}" @if ($errors->password->has('password')) aria-describedby="password-new-error" @endif class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('password', 'password') <p id="password-new-error" role="alert" class="mt-2 text-sm font-medium text-[#9B3028]">{{ $message }}</p> @enderror
                </div>

                <div class="mt-6">
                    <label for="password-confirmation" class="mb-2 block font-semibold text-ink">Konfirmasi password baru</label>
                    <input id="password-confirmation" name="password_confirmation" type="password" autocomplete="new-password" required aria-invalid="{{ $errors->password->has('password_confirmation') ? 'true' : 'false' }}" @if ($errors->password->has('password_confirmation')) aria-describedby="password-confirmation-error" @endif class="min-h-12 w-full rounded-xl border border-[#627B6F] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('password_confirmation', 'password') <p id="password-confirmation-error" role="alert" class="mt-2 text-sm font-medium text-[#9B3028]">{{ $message }}</p> @enderror
                </div>

                <div class="mt-8 border-t border-[#D9E4DD] pt-6 sm:text-right">
                    <button type="submit" class="min-h-12 w-full rounded-xl bg-hospital px-6 font-bold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital sm:w-auto">Ubah password</button>
                </div>
            </form>
        </section>
    </div>
@endsection
