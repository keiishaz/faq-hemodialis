<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_profile_or_change_account(): void
    {
        $this->get(route('admin.profile.edit'))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.profile.update'), [])->assertRedirect(route('admin.login'));
        $this->put(route('admin.profile.password'), [])->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_update_name_without_password_and_keep_own_email(): void
    {
        $user = User::factory()->create([
            'name' => 'Pengelola Lama',
            'email' => 'admin@example.test',
            'password' => 'password-lama-123',
        ]);
        $this->actingAs($user);

        $this->get(route('admin.profile.edit'))
            ->assertOk()
            ->assertSee('Profil admin')
            ->assertSee('Pengelola Lama')
            ->assertSee('Menu admin')
            ->assertDontSee('password-lama-123');

        $this->patch(route('admin.profile.update'), [
            'name' => '  Pengelola Baru  ',
            'email' => '  ADMIN@EXAMPLE.TEST  ',
        ])->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHas('profile_status', 'Profil berhasil diperbarui.');

        $this->assertSame('Pengelola Baru', $user->fresh()->name);
        $this->assertSame('admin@example.test', $user->fresh()->email);
    }

    public function test_email_change_requires_correct_current_password_and_unique_email(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.test',
            'password' => 'password-lama-123',
        ]);
        User::factory()->create(['email' => 'dipakai@example.test']);
        $this->actingAs($user);

        $payload = ['name' => 'Pengelola', 'email' => 'baru@example.test'];

        $this->patch(route('admin.profile.update'), $payload)
            ->assertSessionHasErrors('current_password', null, 'profile');
        $this->assertSame('admin@example.test', $user->fresh()->email);

        $this->patch(route('admin.profile.update'), $payload + ['current_password' => 'salah'])
            ->assertSessionHasErrors('current_password', null, 'profile');
        $this->assertSame('admin@example.test', $user->fresh()->email);

        $this->patch(route('admin.profile.update'), [
            'name' => 'Pengelola',
            'email' => 'dipakai@example.test',
            'current_password' => 'password-lama-123',
        ])->assertSessionHasErrors('email', null, 'profile');

        $this->patch(route('admin.profile.update'), $payload + ['current_password' => 'password-lama-123'])
            ->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHasNoErrors();

        $this->assertSame('baru@example.test', $user->fresh()->email);
    }

    public function test_profile_validation_rejects_invalid_name_and_email(): void
    {
        $user = User::factory()->create(['email' => 'admin@example.test']);
        $this->actingAs($user);

        $this->patch(route('admin.profile.update'), [
            'name' => '   ',
            'email' => 'bukan-email',
        ])->assertSessionHasErrors(['name', 'email'], null, 'profile');

        $this->assertSame('admin@example.test', $user->fresh()->email);
    }

    public function test_password_change_checks_current_password_hashes_new_one_and_rotates_session_and_remember_token(): void
    {
        $user = User::factory()->create([
            'password' => 'password-lama-123',
            'remember_token' => 'token-lama',
        ]);
        $this->actingAs($user);
        $oldSessionId = session()->getId();

        $this->put(route('admin.profile.password'), [
            'current_password' => 'password-lama-123',
            'password' => 'password-baru-456',
            'password_confirmation' => 'password-baru-456',
        ])->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHas('password_status', 'Password berhasil diubah.');

        $this->assertTrue(Hash::check('password-baru-456', $user->fresh()->password));
        $this->assertNotSame('token-lama', $user->fresh()->remember_token);
        $this->assertNotSame($oldSessionId, session()->getId());
        $this->assertAuthenticatedAs($user);
    }

    public function test_password_validation_preserves_old_hash_and_does_not_flash_secrets(): void
    {
        $user = User::factory()->create(['password' => 'password-lama-123']);
        $this->actingAs($user);
        $oldHash = $user->password;

        $this->put(route('admin.profile.password'), [
            'current_password' => 'salah',
            'password' => 'pendek',
            'password_confirmation' => 'berbeda',
        ])->assertSessionHasErrors(['current_password', 'password', 'password_confirmation'], null, 'password');

        $this->assertSame($oldHash, $user->fresh()->password);
        $this->assertArrayNotHasKey('current_password', session()->getOldInput());
        $this->assertArrayNotHasKey('password', session()->getOldInput());
        $this->assertArrayNotHasKey('password_confirmation', session()->getOldInput());
    }
}
