<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfilePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile', ['user' => $request->user()]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->fill($request->safe()->only(['name', 'email']));
        $user->save();

        return to_route('admin.profile.edit')->with('profile_status', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(UpdateProfilePasswordRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->password = $request->validated('password');

        if ($user->getRememberToken() !== null) {
            $user->setRememberToken(Str::random(60));
        }

        $user->save();
        $request->session()->regenerate();

        return to_route('admin.profile.edit')->with('password_status', 'Password berhasil diubah.');
    }
}
