<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_seeder_creates_one_account_with_a_hashed_password(): void
    {
        $this->seed(AdminSeeder::class);

        $admin = User::query()->sole();
        $this->assertSame('Admin FAQ Hemodialisis', $admin->name);
        $this->assertSame('admin@gmail.com', $admin->email);
        $this->assertNotSame('151b4c8900afd170a355c233cec49d28', $admin->password);
        $this->assertTrue(Hash::check('151b4c8900afd170a355c233cec49d28', $admin->password));
    }

    public function test_rerunning_admin_seeder_does_not_reset_an_existing_account(): void
    {
        $this->seed(AdminSeeder::class);
        $admin = User::query()->sole();
        $admin->update([
            'name' => 'Nama Diperbarui',
            'email' => 'baru@example.test',
            'password' => 'sandi-baru-yang-aman-456',
        ]);

        $this->seed(AdminSeeder::class);

        $this->assertSame(1, User::query()->count());
        $this->assertSame('Nama Diperbarui', $admin->fresh()->name);
        $this->assertSame('baru@example.test', $admin->fresh()->email);
        $this->assertTrue(Hash::check('sandi-baru-yang-aman-456', $admin->fresh()->password));
    }

    public function test_database_seeder_runs_admin_and_faq_seeders_idempotently(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(1, User::query()->count());
        $this->assertSame(9, Faq::query()->count());
        $this->assertSame(0, Faq::active()->count());
    }
}
