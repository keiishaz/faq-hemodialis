<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Urutan seeding: akun admin, topik master, konten FAQ, lalu data video.
     * Seluruh seeder bersifat idempoten sehingga aman dijalankan berulang.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            FaqContentSeeder::class,
            VideoTopicSeeder::class,
            VideoSeeder::class,
        ]);
    }
}
