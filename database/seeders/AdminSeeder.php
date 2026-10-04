<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Create the initial admin without changing an existing account.
     */
    public function run(): void
    {
        if (User::query()->exists()) {
            return;
        }

        User::query()->create([
            'name' => 'Admin FAQ Hemodialisis',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('151b4c8900afd170a355c233cec49d28'),
        ]);
    }
}
