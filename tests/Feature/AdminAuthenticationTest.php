<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_login_but_cannot_open_admin_or_logout(): void
    {
        $this->get(route('admin.login'))->assertOk()->assertSee('Masuk ke admin');
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.logout'))->assertRedirect(route('admin.login'));
    }

    public function test_login_normalizes_email_and_logout_removes_admin_access(): void
    {
        $user = User::factory()->create([
            'name' => 'Pengelola',
            'email' => 'admin@example.test',
            'password' => 'rahasia-pengujian-123',
        ]);

        $this->post(route('admin.login.store'), [
            'email' => '  ADMIN@EXAMPLE.TEST  ',
            'password' => 'rahasia-pengujian-123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);

        $dashboardResponse = $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Selamat datang, Pengelola.');

        $this->assertStringContainsString('no-store', $dashboardResponse->headers->get('Cache-Control'));

        $this->post(route('admin.logout'))->assertRedirect(route('admin.login'));
        $this->assertGuest();
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_failed_login_uses_generic_message_and_blocks_after_five_attempts(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('admin.login.store'), [
                'email' => 'tidak-ada@example.test',
                'password' => 'salah',
            ])->assertSessionHasErrors(['email' => 'Email atau password tidak sesuai.']);
        }

        $this->post(route('admin.login.store'), [
            'email' => 'tidak-ada@example.test',
            'password' => 'salah',
        ])->assertSessionHasErrors('email');

        $this->assertStringContainsString(
            'Terlalu banyak percobaan login.',
            session('errors')->first('email'),
        );
        $this->assertGuest();
    }

    public function test_authenticated_admin_cannot_return_to_login_form(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.login'))->assertRedirect(route('admin.dashboard'));
    }
}
