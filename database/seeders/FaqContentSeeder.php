<?php

namespace Database\Seeders;

use App\FaqFullAnswerSanitizer;
use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqContentSeeder extends Seeder
{
    /**
     * Teks placeholder bawaan FaqSeeder, dipakai untuk mengenali FAQ yang
     * belum pernah disunting pengelola.
     */
    private const PLACEHOLDER = 'Jawaban belum tersedia.';

    /**
     * Mengisi jawaban edukasi awal untuk topik FAQ, lalu mengaktifkannya.
     *
     * Sengaja dipisahkan dari FaqSeeder. FaqSeeder hanya menyiapkan topik tanpa
     * mempublikasikan draf, dan hal itu sudah dikunci oleh FaqDatabaseTest serta
     * AdminSeederTest. Seeder ini dijalankan secara sengaja bila jawaban edukasi
     * awal memang ingin ditampilkan:
     *
     *     php artisan db:seed --class=FaqContentSeeder --force
     *
     * Aman dijalankan berulang. FAQ yang sudah disunting pengelola tidak akan
     * ditimpa: hanya baris yang masih berisi placeholder yang diisi. Jawaban
     * lengkap disanitasi memakai FaqFullAnswerSanitizer agar HTML yang tersimpan
     * mengikuti aturan aplikasi.
     */
    public function run(): void
    {
        $sanitizer = new FaqFullAnswerSanitizer;

        foreach ($this->faqs() as $index => $faq) {
            $slug = Str::slug($faq['question']);
            $model = Faq::firstOrNew(['slug' => $slug]);

            $sudahDisunting = $model->exists
                && ($model->short_answer !== self::PLACEHOLDER || filled($model->full_answer));

            if ($sudahDisunting) {
                continue;
            }

            $model->fill([
                'question' => $faq['question'],
                'short_answer' => $faq['short_answer'],
                'full_answer' => $sanitizer->sanitize($faq['full_answer']),
                'is_active' => true,
                'sort_order' => $index + 1,
            ])->save();
        }
    }

    /**
     * Jawaban edukasi awal untuk sembilan topik FAQ.
     *
     * Isi ini bersifat edukasi umum dan tidak menggantikan konsultasi dokter atau
     * tenaga kesehatan. Harap ditinjau tenaga medis sebelum dijadikan acuan resmi.
     *
     * @return array<int, array{question: string, short_answer: string, full_answer: string}>
     */
    private function faqs(): array
    {
        return [
            [
                'question' => 'Bagaimana prosedur hemodialisis dilakukan?',
                'short_answer' => "Hemodialisis dilakukan dengan mengalirkan darah dari tubuh ke mesin melalui jarum pada akses vaskular (fistula, graft, atau kateter). Di dalam mesin, darah dibersihkan oleh dialyzer yang bekerja seperti ginjal buatan, lalu dialirkan kembali ke tubuh.\n\nSatu sesi umumnya berlangsung sekitar 3 sampai 5 jam dan dilakukan 2 sampai 3 kali per minggu, sesuai jadwal yang ditentukan dokter. Selama tindakan, tekanan darah, denyut nadi, dan kondisi Anda dipantau terus oleh petugas.",
                'full_answer' => '<p>Hemodialisis adalah terapi pengganti sebagian fungsi ginjal yang dilakukan secara berkala di rumah sakit atau unit dialisis.</p><ol><li>Sebelum tindakan, berat badan, tekanan darah, dan keluhan Anda diperiksa. Berat badan dipakai untuk menentukan berapa banyak cairan yang perlu ditarik pada sesi tersebut.</li><li>Darah diambil dari akses vaskular, umumnya fistula AV (sambungan pembuluh arteri dan vena), graft, atau kateter, lalu dialirkan ke mesin dialisis.</li><li>Di dalam mesin, darah melewati dialyzer. Di bagian ini zat sisa metabolisme seperti ureum dan kreatinin, serta kelebihan cairan, dipindahkan ke larutan dialisat.</li><li>Darah yang sudah dibersihkan dikembalikan ke tubuh melalui jalur akses yang sama.</li><li>Setelah sesi selesai, akses ditutup dan diberi penekanan sampai perdarahan berhenti, lalu Anda dipantau sebentar sebelum diizinkan pulang.</li></ol><p>Selama sesi berlangsung, petugas memantau tekanan darah, denyut nadi, dan keluhan Anda. Sampaikan segera bila merasa pusing, kram, mual, atau tidak nyaman. <strong>Jangan mengubah jadwal atau melewatkan sesi tanpa persetujuan dokter.</strong></p>',
            ],
            [
                'question' => 'Mengapa pasien dapat merasa lemas atau mengalami penurunan kondisi saat atau setelah hemodialisis?',
                'short_answer' => "Keluhan lemas, pusing, kram, atau mual saat dan setelah hemodialisis cukup sering terjadi. Penyebabnya antara lain penurunan tekanan darah karena cairan ditarik cukup cepat, perubahan keseimbangan zat dalam darah, dan anemia yang menyertai penyakit ginjal kronik.\n\nSampaikan keluhan ini kepada petugas, karena pengaturan terapi dapat disesuaikan.",
                'full_answer' => '<p>Perasaan lemas atau penurunan kondisi saat dan setelah hemodialisis umumnya berkaitan dengan perubahan yang terjadi cukup cepat di dalam tubuh. Beberapa penyebab yang sering:</p><ul><li><strong>Penurunan tekanan darah</strong> akibat cairan tubuh ditarik melalui mesin (ultrafiltrasi), terutama bila cairan yang harus dibuang banyak.</li><li><strong>Kram otot</strong> karena pergeseran cairan dan elektrolit selama sesi.</li><li><strong>Anemia</strong> pada penyakit ginjal kronik, sehingga pasokan oksigen ke jaringan berkurang.</li><li><strong>Makan atau minum terlalu banyak sebelum tindakan</strong>, serta kenaikan berat badan antarsesi yang berlebihan.</li><li><strong>Kelelahan setelah tindakan</strong> yang bisa berlangsung beberapa jam.</li></ul><p>Yang dapat Anda lakukan: ceritakan keluhan dengan jelas kepada petugas, catat kapan munculnya, dan ikuti anjuran pembatasan cairan serta jadwal obat. <em>Jangan mengurangi atau menghentikan sesi sendiri</em>, karena justru dapat memperberat kondisi. Bila keluhan menetap atau makin berat, konsultasikan ke dokter.</p>',
            ],
            [
                'question' => 'Makanan apa yang dianjurkan dan perlu dihindari oleh pasien hemodialisis?',
                'short_answer' => "Dianjurkan: protein dan kalori yang cukup sesuai anjuran dokter atau ahli gizi, serta pengaturan garam dan cairan.\n\nPerlu dibatasi: makanan tinggi natrium (garam, makanan olahan, penyedap), tinggi kalium (pisang, alpukat, kentang, kelapa, air kelapa), dan tinggi fosfor (jeroan, keju, minuman bersoda).\n\nJenis dan jumlahnya harus disesuaikan dengan kondisi Anda oleh dokter atau ahli gizi.",
                'full_answer' => '<p>Pengaturan makan adalah bagian penting dari terapi hemodialisis. Tujuannya menjaga keseimbangan cairan dan zat dalam tubuh. Anjuran umum yang biasanya diberikan:</p><ul><li><strong>Protein cukup</strong> untuk mempertahankan kekuatan tubuh, karena sebagian protein ikut hilang selama dialisis.</li><li><strong>Kalori cukup</strong> agar berat badan tidak turun berlebihan.</li><li><strong>Batasi natrium</strong>: kurangi garam meja, penyedap, makanan olahan, mie instan, makanan kaleng, dan asinan. Rasa gurih dapat diperoleh dari bumbu alami seperti bawang, jahe, dan rempah.</li><li><strong>Batasi kalium</strong>: pisang, alpukat, kentang, kelapa dan air kelapa, bayam, serta beberapa jenis buah kering. Cara memasak seperti merendam dan membuang air rebusan dapat membantu.</li><li><strong>Batasi fosfor</strong>: jeroan, kuning telur berlebihan, keju, kacang-kacangan tertentu, dan minuman bersoda.</li><li><strong>Atur cairan</strong> sesuai sisa produksi urine dan anjuran dokter, karena kelebihan cairan dapat membuat sesak dan meningkatkan beban jantung.</li></ul><p><strong>Setiap pasien berbeda.</strong> Jumlah protein, cairan, dan pembatasan zat harus ditentukan oleh dokter atau ahli gizi berdasarkan hasil pemeriksaan Anda. Hindari mengonsumsi suplemen atau obat herbal tanpa sepengetahuan tim medis.</p>',
            ],
            [
                'question' => 'Apa yang terjadi pada tubuh ketika fungsi ginjal menurun hingga memerlukan hemodialisis?',
                'short_answer' => "Saat fungsi ginjal menurun berat, ginjal tidak lagi mampu membuang sisa metabolisme dan kelebihan cairan. Akibatnya zat sisa menumpuk, cairan berlebih dapat menimbulkan bengkak dan sesak, keseimbangan elektrolit terganggu, serta tekanan darah dan produksi sel darah merah ikut terdampak.\n\nHemodialisis menggantikan sebagian fungsi tersebut.",
                'full_answer' => '<p>Ginjal memiliki beberapa tugas utama: menyaring darah dan membuang sisa metabolisme, mengatur keseimbangan cairan dan elektrolit, membantu mengendalikan tekanan darah, merangsang pembentukan sel darah merah, serta mengaktifkan vitamin D.</p><p>Ketika fungsi ginjal menurun berat, tugas-tugas itu tidak lagi berjalan dengan baik, sehingga terjadi:</p><ul><li><strong>Penumpukan zat sisa</strong> seperti ureum dan kreatinin dalam darah, yang dapat menimbulkan mual, lemas, dan hilang nafsu makan.</li><li><strong>Kelebihan cairan</strong> sehingga muncul bengkak pada kaki atau kelopak mata, sesak napas, dan beban berlebih pada jantung.</li><li><strong>Gangguan keseimbangan elektrolit</strong>, misalnya kalium yang terlalu tinggi, yang dapat mengganggu irama jantung.</li><li><strong>Anemia</strong> karena produksi hormon perangsang sel darah merah berkurang.</li><li><strong>Gangguan kesehatan tulang</strong> akibat terganggunya pengaturan kalsium dan fosfor.</li></ul><p>Hemodialisis mengambil alih sebagian kerja penyaringan dan pembuangan cairan tersebut, sehingga keluhan berkurang dan kondisi tubuh lebih terjaga.</p>',
            ],
            [
                'question' => 'Bagaimana perbedaan ginjal sehat dengan ginjal yang mengalami gangguan hingga memerlukan hemodialisis?',
                'short_answer' => "Ginjal sehat bekerja otomatis: menyaring darah, membuang sisa metabolisme, mengatur cairan dan elektrolit, mengendalikan tekanan darah, serta menghasilkan hormon. Ginjal yang mengalami gangguan berat kehilangan sebagian besar kemampuan itu, sehingga penyaringan harus dibantu mesin dan pengaturan dilakukan terus-menerus melalui obat, diet, dan pembatasan cairan.",
                'full_answer' => '<p>Perbedaan utama terletak pada kemampuan bekerja secara mandiri dan menyeluruh:</p><ul><li><strong>Ginjal sehat</strong> menyaring darah sepanjang waktu, membuang sisa metabolisme, mengatur jumlah air dalam tubuh, menjaga keseimbangan elektrolit, membantu mengatur tekanan darah, serta menghasilkan hormon untuk pembentukan sel darah merah dan pengaturan kesehatan tulang.</li><li><strong>Ginjal yang mengalami gangguan berat</strong> tidak mampu menjalankan fungsi tersebut. Zat sisa dan kelebihan cairan menumpuk, tekanan darah dan elektrolit tidak stabil, serta muncul anemia dan gangguan tulang.</li><li><strong>Akibatnya</strong> penyaringan perlu dibantu mesin dialisis secara berkala, ditambah pengaturan makanan, pembatasan cairan, dan obat-obatan yang dijalankan terus-menerus.</li><li><strong>Fungsi yang sudah hilang</strong> umumnya tidak kembali seperti semula. Karena itu terapi pengganti fungsi ginjal bersifat jangka panjang, kecuali pada kondisi gagal ginjal akut yang masih mungkin pulih.</li></ul><p>Terapi pengganti fungsi ginjal terdiri dari hemodialisis, dialisis peritoneum, dan transplantasi ginjal. Pilihan terapi ditentukan bersama dokter.</p>',
            ],
            [
                'question' => 'Dalam kondisi apa hemodialisis dapat dihentikan?',
                'short_answer' => "Penghentian hemodialisis adalah keputusan medis yang diambil dokter bersama pasien dan keluarga, tidak boleh diputuskan sendiri. Hanya tim medis yang merawat Anda yang dapat menilai apakah terapi masih memberi manfaat, perlu diubah, atau perlu dialihkan ke bentuk terapi lain.\n\nMelewatkan atau menghentikan sesi tanpa pengawasan berbahaya bagi tubuh.",
                'full_answer' => '<p>Hemodialisis pada umumnya merupakan terapi jangka panjang bagi pasien dengan penyakit ginjal kronik tahap akhir. Menghentikan terapi bukan tindakan yang bisa diambil sendiri oleh pasien maupun keluarga, karena berkaitan erat dengan keselamatan.</p><p>Beberapa hal yang perlu dipahami:</p><ul><li><strong>Terapi bisa berhenti karena tidak diperlukan lagi</strong>, misalnya setelah pasien menjalani transplantasi ginjal yang berhasil, atau pada gagal ginjal akut yang fungsinya pulih kembali. Keputusan ini diambil dokter berdasarkan hasil pemeriksaan.</li><li><strong>Terapi dapat diubah bentuknya</strong>, misalnya beralih ke dialisis peritoneum atau transplantasi ginjal, sesuai kondisi dan pilihan pasien.</li><li><strong>Pada kondisi tertentu</strong>, tim medis bersama pasien dan keluarga dapat membahas penghentian terapi bila dinilai tidak lagi memberikan manfaat, dengan tetap mengutamakan kenyamanan pasien. Pembahasan seperti ini selalu dilakukan secara terbuka bersama dokter yang merawat.</li></ul><p><strong>Yang penting:</strong> melewatkan sesi atau menghentikannya sendiri tanpa pengawasan dapat menimbulkan penumpukan racun, kelebihan cairan, dan gangguan irama jantung yang membahayakan nyawa. Bicarakan setiap keraguan Anda dengan dokter dan tim dialisis, termasuk bila merasa lelah menjalani terapi.</p>',
            ],
            [
                'question' => 'Bagaimana cara mencegah gangguan ginjal yang dapat menyebabkan kebutuhan hemodialisis?',
                'short_answer' => "Menjaga tekanan darah dan gula darah tetap terkontrol, cukup minum air, tidak merokok, menjaga berat badan ideal, serta berhati-hati dengan obat pereda nyeri jangka panjang tanpa pengawasan dokter.\n\nBagi yang berisiko (hipertensi, diabetes, riwayat keluarga), lakukan pemeriksaan fungsi ginjal secara berkala.",
                'full_answer' => '<p>Upaya pencegahan diarahkan pada pengendalian faktor yang paling sering merusak ginjal:</p><ul><li><strong>Kendalikan tekanan darah</strong> pada angka yang dianjurkan dokter, melalui pola makan rendah garam, aktivitas fisik, dan obat bila diperlukan.</li><li><strong>Kendalikan gula darah</strong> bagi penderita diabetes, karena diabetes merupakan salah satu penyebab utama gangguan ginjal.</li><li><strong>Hindari merokok</strong> dan batasi konsumsi minuman beralkohol.</li><li><strong>Berhati-hati dengan obat</strong>: pemakaian obat pereda nyeri golongan tertentu dalam jangka panjang tanpa pengawasan dapat membebani ginjal. Konsultasikan juga sebelum memakai obat herbal atau suplemen.</li><li><strong>Minum air yang cukup</strong> dan jaga berat badan ideal.</li><li><strong>Lakukan pemeriksaan berkala</strong>, terutama bila Anda memiliki hipertensi, diabetes, riwayat gangguan ginjal di keluarga, atau pernah mengalami penyakit ginjal. Pemeriksaan sederhana seperti tekanan darah, kadar gula, ureum, kreatinin, dan pemeriksaan urine dapat mendeteksi gangguan lebih awal.</li></ul><p>Gangguan ginjal yang ditemukan pada tahap awal lebih besar peluangnya untuk diperlambat perkembangannya.</p>',
            ],
            [
                'question' => 'Apakah pasien yang menjalani hemodialisis dapat sembuh?',
                'short_answer' => "Hemodialisis tidak menyembuhkan penyakit ginjal, melainkan menggantikan sebagian fungsi ginjal agar tubuh tetap terjaga dan keluhan berkurang. Pada gagal ginjal kronik tahap akhir, fungsi ginjal umumnya tidak kembali normal; penyembuhan menyeluruh umumnya memerlukan transplantasi ginjal.\n\nPada gagal ginjal akut, fungsi ginjal masih dapat pulih sehingga dialisis dapat bersifat sementara.",
                'full_answer' => '<p>Perlu dibedakan antara pengobatan dan penggantian fungsi:</p><ul><li><strong>Hemodialisis bukan obat penyembuh.</strong> Terapi ini menggantikan sebagian fungsi ginjal, yaitu membuang zat sisa dan kelebihan cairan, sehingga keluhan berkurang dan tubuh tetap terjaga.</li><li><strong>Pada gagal ginjal kronik tahap akhir</strong>, kerusakan ginjal umumnya bersifat menetap, sehingga terapi pengganti fungsi ginjal perlu dijalani berkelanjutan.</li><li><strong>Pada gagal ginjal akut</strong>, misalnya akibat dehidrasi berat, infeksi, atau keracunan, fungsi ginjal masih dapat pulih sehingga dialisis hanya diperlukan sementara.</li><li><strong>Transplantasi ginjal</strong> merupakan terapi yang dapat memulihkan fungsi ginjal secara menyeluruh, bila tersedia donor yang sesuai dan kondisi pasien memungkinkan. Pilihan ini dibicarakan bersama dokter.</li></ul><p>Meskipun bukan menyembuhkan, hemodialisis yang dijalani secara teratur membantu pasien mempertahankan kualitas hidup, mengurangi keluhan, dan tetap dapat beraktivitas. Menjalani sesi secara disiplin serta mengikuti anjuran obat dan makanan adalah kunci hasil terapi yang baik.</p>',
            ],
            [
                'question' => 'Apa manfaat dan alasan dilakukannya hemodialisis?',
                'short_answer' => "Hemodialisis membuang zat sisa metabolisme dan cairan berlebih dari tubuh, menjaga keseimbangan elektrolit, membantu mengendalikan tekanan darah, serta mengurangi keluhan seperti sesak, mual, dan lemas.\n\nTujuan utamanya: membuat pasien merasa lebih baik, lebih aman, dan tetap mampu beraktivitas.",
                'full_answer' => '<p>Hemodialisis dilakukan untuk menggantikan sebagian pekerjaan ginjal yang sudah tidak mampu menjalankan fungsinya. Manfaat utamanya:</p><ul><li><strong>Membuang zat sisa metabolisme</strong> seperti ureum dan kreatinin yang menumpuk dalam darah.</li><li><strong>Membuang kelebihan cairan</strong>, sehingga bengkak dan sesak napas berkurang.</li><li><strong>Menjaga keseimbangan elektrolit</strong>, terutama kalium, agar irama jantung lebih aman.</li><li><strong>Membantu mengendalikan tekanan darah</strong> dan mengurangi beban kerja jantung.</li><li><strong>Memperbaiki keluhan</strong> seperti mual, hilang nafsu makan, lemas, dan gangguan tidur, sehingga kualitas hidup meningkat.</li></ul><p>Alasan utama terapi ini dianjurkan adalah ketika fungsi ginjal menurun hingga tidak lagi mampu menjaga keseimbangan tubuh, misalnya pada penumpukan zat sisa yang berat, kelebihan cairan yang menimbulkan sesak, atau kadar kalium yang berbahaya. Manfaat tersebut paling optimal bila sesi dijalani sesuai jadwal, tidak dilewatkan, dan didukung pengaturan makanan, cairan, serta obat dari dokter.</p>',
            ],
        ];
    }
}
