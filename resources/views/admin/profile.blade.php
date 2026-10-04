@extends('layouts.admin')

@section('title', 'Profil')

@section('content')
    <div>
        <h1 class="text-[1.625rem] font-semibold leading-tight tracking-tight text-hospital-deep">Profil</h1>

        <section aria-labelledby="profile-details-title" class="mt-6 rounded-xl border border-[#D6E5EE] bg-white p-5">
            <h2 id="profile-details-title" class="text-lg font-semibold tracking-tight text-hospital-deep">Informasi akun</h2>
            <p class="mt-2 text-sm leading-relaxed text-[#52697B]">Password saat ini hanya diperlukan saat email diubah.</p>

            @if (session('profile_status'))
                <p role="status" class="mt-5 rounded-xl border border-[#9DD4E8] bg-sage px-4 py-3 font-medium text-hospital-deep">{{ session('profile_status') }}</p>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST" class="mt-5">
                @csrf
                @method('PATCH')

                <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="profile-name" class="mb-2 block text-sm font-semibold text-ink">Nama</label>
                    <input id="profile-name" name="name" type="text" autocomplete="name" maxlength="100" required value="{{ old('name', $user->name) }}" aria-invalid="{{ $errors->profile->has('name') ? 'true' : 'false' }}" @if ($errors->profile->has('name')) aria-describedby="profile-name-error" @endif class="min-h-11 w-full rounded-lg border border-[#9FB8C9] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('name', 'profile') <p id="profile-name-error" role="alert" class="mt-2 text-sm font-medium text-[#A52D38]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="profile-email" class="mb-2 block text-sm font-semibold text-ink">Email</label>
                    <input id="profile-email" name="email" type="email" autocomplete="email" maxlength="255" required value="{{ old('email', $user->email) }}" aria-invalid="{{ $errors->profile->has('email') ? 'true' : 'false' }}" @if ($errors->profile->has('email')) aria-describedby="profile-email-error" @endif class="min-h-11 w-full rounded-lg border border-[#9FB8C9] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('email', 'profile') <p id="profile-email-error" role="alert" class="mt-2 text-sm font-medium text-[#A52D38]">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="profile-current-password" class="mb-2 block text-sm font-semibold text-ink">Password saat ini <span class="font-normal text-[#52697B]">(jika email diubah)</span></label>
                    <input id="profile-current-password" name="current_password" type="password" autocomplete="current-password" aria-invalid="{{ $errors->profile->has('current_password') ? 'true' : 'false' }}" @if ($errors->profile->has('current_password')) aria-describedby="profile-current-password-error" @endif class="min-h-11 w-full rounded-lg border border-[#9FB8C9] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('current_password', 'profile') <p id="profile-current-password-error" role="alert" class="mt-2 text-sm font-medium text-[#A52D38]">{{ $message }}</p> @enderror
                </div>
                </div>

                <div class="mt-5 border-t border-[#D6E5EE] pt-4 sm:text-right">
                    <button type="submit" class="min-h-11 w-full rounded-lg bg-hospital px-6 text-sm font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital sm:w-auto">Simpan profil</button>
                </div>
            </form>
        </section>

        <section aria-labelledby="profile-password-title" class="mt-6 rounded-xl border border-[#D6E5EE] bg-white p-5">
            <h2 id="profile-password-title" class="text-lg font-semibold tracking-tight text-hospital-deep">Ubah password</h2>
            <p class="mt-2 text-sm leading-relaxed text-[#52697B]">Gunakan password baru minimal 12 karakter.</p>

            @if (session('password_status'))
                <p role="status" class="mt-5 rounded-xl border border-[#9DD4E8] bg-sage px-4 py-3 font-medium text-hospital-deep">{{ session('password_status') }}</p>
            @endif

            <form action="{{ route('admin.profile.password') }}" method="POST" class="mt-5">
                @csrf
                @method('PUT')

                <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="password-current" class="mb-2 block text-sm font-semibold text-ink">Password saat ini</label>
                    <input id="password-current" name="current_password" type="password" autocomplete="current-password" required aria-invalid="{{ $errors->password->has('current_password') ? 'true' : 'false' }}" @if ($errors->password->has('current_password')) aria-describedby="password-current-error" @endif class="min-h-11 w-full rounded-lg border border-[#9FB8C9] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('current_password', 'password') <p id="password-current-error" role="alert" class="mt-2 text-sm font-medium text-[#A52D38]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password-new" class="mb-2 block text-sm font-semibold text-ink">Password baru</label>
                    <input id="password-new" name="password" type="password" autocomplete="new-password" minlength="12" required aria-invalid="{{ $errors->password->has('password') ? 'true' : 'false' }}" @if ($errors->password->has('password')) aria-describedby="password-new-error" @endif class="min-h-11 w-full rounded-lg border border-[#9FB8C9] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('password', 'password') <p id="password-new-error" role="alert" class="mt-2 text-sm font-medium text-[#A52D38]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password-confirmation" class="mb-2 block text-sm font-semibold text-ink">Konfirmasi password baru</label>
                    <input id="password-confirmation" name="password_confirmation" type="password" autocomplete="new-password" required aria-invalid="{{ $errors->password->has('password_confirmation') ? 'true' : 'false' }}" @if ($errors->password->has('password_confirmation')) aria-describedby="password-confirmation-error" @endif class="min-h-11 w-full rounded-lg border border-[#9FB8C9] bg-white px-4 text-base text-ink focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital">
                    @error('password_confirmation', 'password') <p id="password-confirmation-error" role="alert" class="mt-2 text-sm font-medium text-[#A52D38]">{{ $message }}</p> @enderror
                </div>
                </div>

                <div class="mt-5 border-t border-[#D6E5EE] pt-4 sm:text-right">
                    <button type="submit" class="min-h-11 w-full rounded-lg bg-hospital px-6 text-sm font-semibold text-white transition-colors hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-hospital sm:w-auto">Ubah password</button>
                </div>
            </form>
        </section>
    </div>
@endsection
