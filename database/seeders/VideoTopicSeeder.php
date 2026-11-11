<?php

namespace Database\Seeders;

use App\Models\VideoTopic;
use Illuminate\Database\Seeder;

class VideoTopicSeeder extends Seeder
{
    /**
     * Daftar topik (data master) untuk pengelompokan video edukasi.
     *
     * Seeder bersifat idempoten: topik yang sudah ada hanya diperbarui
     * urutannya, sehingga aman dijalankan berulang.
     */
    public function run(): void
    {
        $topics = [
            ['nama' => 'Batu Ginjal & Saluran Kemih', 'urutan' => 1],
            ['nama' => 'Diabetes Melitus', 'urutan' => 2],
            ['nama' => 'Hemodialisis', 'urutan' => 3],
            ['nama' => 'Hipertensi', 'urutan' => 4],
            ['nama' => 'Kesehatan Ginjal', 'urutan' => 5],
            ['nama' => 'Peritoneal Dialisis', 'urutan' => 6],
            ['nama' => 'serangan jantung', 'urutan' => 7],
        ];

        foreach ($topics as $topik) {
            VideoTopic::query()->updateOrCreate(
                ['nama' => $topik['nama']],
                ['urutan' => $topik['urutan']],
            );
        }
    }
}
