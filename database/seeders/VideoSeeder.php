<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Data video edukasi yang sudah memiliki tautan YouTube.
     *
     * Sumber awal: daftar video mahasiswa Program Studi Promosi Kesehatan
     * Kelas 3A, Poltekkes Kemenkes Bengkulu. Hanya entri yang telah memiliki
     * tautan tayang yang disemai, sehingga data yang belum diunggah tidak
     * ikut tersalin ke lingkungan baru.
     *
     * Seeder bersifat idempoten: dijalankan berulang tidak menggandakan data.
     */
    public function run(): void
    {
        $videos = [
            [
                'judul' => 'Kebiasaan Sehari-hari yang Tanpa Disadari Pemicu Hernia | Bincang Sehati DAAI TV',
                'slug' => 'kebiasaan-sehari-hari-yang-tanpa-disadari-pemicu-hernia-bincang-sehati-daai-tv',
                'pembicara' => 'Bincang Sehati',
                'kategori' => 'Hemodialisis',
                'youtube_url' => 'https://youtu.be/X2g6yJBTvrU',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 1,
            ],
            [
                'judul' => 'Cegah Hipertensi | Bincang Sehati',
                'slug' => 'cegah-hipertensi-bincang-sehati',
                'pembicara' => 'Bincang Sehati',
                'kategori' => 'Hipertensi',
                'youtube_url' => 'https://youtu.be/7zpPCjTDvlw',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 2,
            ],
            [
                'judul' => 'Diet Sehat untuk Mencegah dan Mengendalikan Hipertensi',
                'slug' => 'diet-sehat-untuk-mencegah-dan-mengendalikan-hipertensi',
                'pembicara' => 'Anderine Habibullah Utami',
                'kategori' => 'Hemodialisis',
                'youtube_url' => 'https://youtu.be/TLDyX3SwnwE?si=CJUETkxKxUJWVuu9',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 3,
            ],
            [
                'judul' => 'Mengenal Diabetes Melitus: Penyebab, Gejala, dan Faktor Risiko',
                'slug' => 'mengenal-diabetes-melitus-penyebab-gejala-dan-faktor-risiko',
                'pembicara' => 'Cindy Agtuwen',
                'kategori' => 'Diabetes Melitus',
                'youtube_url' => 'https://youtu.be/JfvGyQ7dzKk?si=vk5_WnN5hnbcRobM',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 4,
            ],
            [
                'judul' => 'Pola Makan Sehat bagi Penderita Diabetes Melitus',
                'slug' => 'pola-makan-sehat-bagi-penderita-diabetes-melitus',
                'pembicara' => 'Dinda Carollyn',
                'kategori' => 'Diabetes Melitus',
                'youtube_url' => 'https://youtu.be/rQUheK12hao?si=FtFBjPhI7f_S-AP0',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 5,
            ],
            [
                'judul' => 'Hidup Sehat Tanpa Batu Ginjal: Perawatan di Rumah dan Pencegahan Kekambuhan',
                'slug' => 'hidup-sehat-tanpa-batu-ginjal-perawatan-di-rumah-dan-pencegahan-kekambuhan',
                'pembicara' => 'Harlena',
                'kategori' => 'Batu Ginjal & Saluran Kemih',
                'youtube_url' => 'https://youtu.be/asVkVZAknQc?si=A6I33_kNj2pPeAcs',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 6,
            ],
            [
                'judul' => 'Mengenal Penyakit Ginjal Kronis dan Mengapa Harus Hemodialisis',
                'slug' => 'mengenal-penyakit-ginjal-kronis-dan-mengapa-harus-hemodialisis',
                'pembicara' => 'Helvi Trianita',
                'kategori' => 'Hemodialisis',
                'youtube_url' => 'https://youtu.be/upX02HgQxEo?si=RQM1PpJUxTSDUm7G',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 7,
            ],
            [
                'judul' => 'Mengenal Prosedur Hemodialisis: Apa yang Terjadi Saat Cuci Darah?',
                'slug' => 'mengenal-prosedur-hemodialisis-apa-yang-terjadi-saat-cuci-darah',
                'pembicara' => 'Indah Wulan Ramdania',
                'kategori' => 'Hemodialisis',
                'youtube_url' => 'https://youtu.be/QM0Q2XqE0nc?si=jdB3FyYL1Z3ANa8Y',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 8,
            ],
            [
                'judul' => 'Perawatan Akses Vaskular: Menjaga AV Fistula agar Tetap Berfungsi',
                'slug' => 'perawatan-akses-vaskular-menjaga-av-fistula-agar-tetap-berfungsi',
                'pembicara' => 'Livya Rahmadhanti Putri Hambali',
                'kategori' => 'Hemodialisis',
                'youtube_url' => 'https://youtu.be/MwOc0UYSkb8?feature=shared',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 9,
            ],
            [
                'judul' => 'Kepatuhan Minum Obat dan Pemeriksaan Rutin Pasien Hemodialisis',
                'slug' => 'kepatuhan-minum-obat-dan-pemeriksaan-rutin-pasien-hemodialisis',
                'pembicara' => 'Melia Malayana',
                'kategori' => 'Hemodialisis',
                'youtube_url' => 'https://youtu.be/4kpMoRF-8-s?si=HmWrIcrIpEOb7lEL',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 10,
            ],
            [
                'judul' => 'Perjalanan Penyakit Ginjal dari Stadium Awal hingga Gagal Ginjal Stadium Akhir',
                'slug' => 'perjalanan-penyakit-ginjal-dari-stadium-awal-hingga-gagal-ginjal-stadium-akhir',
                'pembicara' => 'Nayya Erian Hidayah',
                'kategori' => 'Kesehatan Ginjal',
                'youtube_url' => 'https://youtu.be/HoWq1VzbFA8?si=rvz_2qUyRNIhv5qq',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 11,
            ],
            [
                'judul' => 'Bahaya Penggunaan Obat Tanpa Resep dan Obat Pereda Nyeri terhadap Ginjal',
                'slug' => 'bahaya-penggunaan-obat-tanpa-resep-dan-obat-pereda-nyeri-terhadap-ginjal',
                'pembicara' => 'Nurdelia Merisyah',
                'kategori' => 'Kesehatan Ginjal',
                'youtube_url' => 'https://youtu.be/Q6ZPNxHOoPM?si=4hzOHBv7sNSV93aY',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 12,
            ],
            [
                'judul' => 'Pengaruh Merokok dan Alkohol terhadap Kesehatan Ginjal',
                'slug' => 'pengaruh-merokok-dan-alkohol-terhadap-kesehatan-ginjal',
                'pembicara' => 'Olga Pratiwi',
                'kategori' => 'Kesehatan Ginjal',
                'youtube_url' => 'https://youtu.be/CLDK-UwKt24?si=pYWMLzFhpbfy8vVq',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 13,
            ],
            [
                'judul' => 'Anemia pada Pasien Gagal Ginjal: Penyebab, Gejala, dan Penanganan',
                'slug' => 'anemia-pada-pasien-gagal-ginjal-penyebab-gejala-dan-penanganan',
                'pembicara' => 'Salwa Sera Dwi Talita',
                'kategori' => 'Hemodialisis',
                'youtube_url' => 'https://youtu.be/_O9qDIinEtM?si=3aqQ1MvjHv9CeCjt',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 14,
            ],
            [
                'judul' => 'Gangguan Tidur dan Kelelahan pada Pasien Hemodialisis',
                'slug' => 'gangguan-tidur-dan-kelelahan-pada-pasien-hemodialisis',
                'pembicara' => 'Wahyuni Nur Aini',
                'kategori' => 'Hemodialisis',
                'youtube_url' => 'https://youtu.be/-ezKughEiHI?si=VuMe7l6gbJlbGN6R',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 15,
            ],
            [
                'judul' => 'Mengenali Tanda Bahaya yang Mengharuskan Pasien Segera ke Rumah Sakit',
                'slug' => 'mengenali-tanda-bahaya-yang-mengharuskan-pasien-segera-ke-rumah-sakit',
                'pembicara' => 'Wiwik Tri Aniza',
                'kategori' => 'Kesehatan Ginjal',
                'youtube_url' => 'https://youtu.be/nozf-V7u8Vk?si=gl6b9X0sT9iG9GTB',
                'durasi' => null,
                'deskripsi' => null,
                'is_active' => 1,
                'sort_order' => 16,
            ],
        ];

        foreach ($videos as $video) {
            Video::query()->updateOrCreate(
                ['slug' => $video['slug']],
                $video,
            );
        }
    }
}
