<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Urutan seeding: akun admin, materi FAQ dari dokumen edukasi, topik
     * master, lalu data video.
     *
     * FaqContentSeeder menyiapkan sembilan topik ringkas bawaan, kemudian
     * FaqMateriSeeder menggantinya dengan sepuluh pertanyaan lengkap yang
     * disalin dari dokumen materi hemodialisa. Seluruh seeder aman dijalankan
     * berulang.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            FaqContentSeeder::class,
            FaqMateriSeeder::class,
            VideoTopicSeeder::class,
            VideoSeeder::class,
        ]);
    }
}
