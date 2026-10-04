<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    /**
     * Seed the initial FAQ topics without publishing placeholder answers.
     */
    public function run(): void
    {
        $questions = [
            'Bagaimana prosedur hemodialisis dilakukan?',
            'Mengapa pasien dapat merasa lemas atau mengalami penurunan kondisi saat atau setelah hemodialisis?',
            'Makanan apa yang dianjurkan dan perlu dihindari oleh pasien hemodialisis?',
            'Apa yang terjadi pada tubuh ketika fungsi ginjal menurun hingga memerlukan hemodialisis?',
            'Bagaimana perbedaan ginjal sehat dengan ginjal yang mengalami gangguan hingga memerlukan hemodialisis?',
            'Dalam kondisi apa hemodialisis dapat dihentikan?',
            'Bagaimana cara mencegah gangguan ginjal yang dapat menyebabkan kebutuhan hemodialisis?',
            'Apakah pasien yang menjalani hemodialisis dapat sembuh?',
            'Apa manfaat dan alasan dilakukannya hemodialisis?',
        ];

        foreach ($questions as $index => $question) {
            Faq::firstOrCreate(
                ['slug' => Str::slug($question)],
                [
                    'question' => $question,
                    'short_answer' => 'Jawaban belum tersedia.',
                    'full_answer' => null,
                    'is_active' => false,
                    'sort_order' => $index + 1,
                ],
            );
        }
    }
}
