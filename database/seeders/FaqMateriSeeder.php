<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FaqMateriSeeder extends Seeder
{
    /**
     * Sepuluh pertanyaan dan jawaban yang disusun dari dokumen
     * "MATERI HEMODIALISA LENGKAP 1" untuk dibaca masyarakat dan pasien.
     *
     * Isi mengikuti seluruh keterangan pada dokumen, termasuk kutipan
     * sumbernya, tanpa menambah maupun mengurangi fakta. Penulisan dirapikan:
     * setiap judul bagian diubah menjadi kalimat tanya, uraian disusun dalam
     * paragraf dan daftar yang runtut, serta penulisan istilah dan tanda baca
     * diseragamkan.
     *
     * Seeder bersifat menggantikan: baris FAQ lama dihapus, lalu sepuluh
     * pertanyaan berikut dimasukkan, sehingga hasilnya selalu sepuluh
     * pertanyaan yang sama.
     *
     *     php artisan db:seed --class=FaqMateriSeeder --force
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Bagaimana prosedur hemodialisis dilakukan, mulai dari sebelum hingga setelah terapi?',
                'short_answer' => 'Secara umum, prosedur hemodialisis dibagi menjadi tiga tahap, yaitu sebelum, selama, dan setelah dialisis (NIDDK, n.d.).',
                'full_answer' => '<p>Secara umum, prosedur hemodialisis dibagi menjadi tiga tahap, yaitu sebelum, selama, dan setelah dialisis (NIDDK, n.d.).</p>'
                    .'<h3>Sebelum hemodialisis</h3>'
                    .'<p>Sebelum pasien dihubungkan dengan mesin, tenaga kesehatan melakukan beberapa pemeriksaan (NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li>Mengidentifikasi pasien serta memastikan jadwal dan resep dialisis.</li>'
                    .'<li>Menimbang berat badan sebelum dialisis.</li>'
                    .'<li>Mengukur tekanan darah, denyut nadi, dan kondisi umum pasien.</li>'
                    .'<li>Menilai keluhan pasien, seperti sesak, bengkak (edema), pusing, mual, atau lemas.</li>'
                    .'<li>Memeriksa akses vaskular, misalnya <em>AV fistula</em>, <em>AV graft</em>, atau kateter vena sentral.</li>'
                    .'<li>Menentukan jumlah cairan yang perlu dikeluarkan berdasarkan berat badan sebelum dialisis dan berat badan kering (<em>dry weight</em>).</li>'
                    .'<li>Memastikan resep dialisis sesuai instruksi dokter.</li>'
                    .'</ul>'
                    .'<p>Pada pasien dengan fistula atau graft, akses umumnya digunakan dengan dua jarum, sedangkan kateter dapat langsung dihubungkan ke selang mesin dialisis (NIDDK, n.d.).</p>'
                    .'<h3>Selama hemodialisis</h3>'
                    .'<p>Secara sederhana, alurnya adalah: akses vaskular &rarr; darah keluar &rarr; mesin atau pompa darah &rarr; <em>dialyzer</em> &rarr; darah dibersihkan &rarr; darah kembali ke tubuh.</p>'
                    .'<p>Di dalam <em>dialyzer</em>, darah mengalir melalui serat-serat berongga yang sangat tipis, sedangkan cairan dialisis mengalir berlawanan arah. Zat sisa metabolisme dan kelebihan zat tertentu berpindah dari darah menuju cairan dialisis, lalu darah yang sudah difiltrasi kembali ke tubuh. Selama proses tersebut, tenaga kesehatan memantau (NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li>tekanan darah;</li>'
                    .'<li>denyut nadi;</li>'
                    .'<li>kondisi umum pasien;</li>'
                    .'<li>akses vaskular;</li>'
                    .'<li>aliran darah;</li>'
                    .'<li>jumlah cairan yang dikeluarkan;</li>'
                    .'<li>keluhan yang muncul, seperti pusing, mual, kram, nyeri kepala, atau lemas.</li>'
                    .'</ul>'
                    .'<h3>Setelah hemodialisis</h3>'
                    .'<p>Setelah terapi selesai, beberapa hal berikut dilakukan (NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li>Aliran darah dihentikan sesuai prosedur.</li>'
                    .'<li>Jarum pada fistula atau graft dilepas, atau kateter ditangani sesuai protokol.</li>'
                    .'<li>Area akses diperiksa untuk memastikan tidak terjadi perdarahan.</li>'
                    .'<li>Tekanan darah dan kondisi pasien dievaluasi kembali.</li>'
                    .'<li>Pasien ditimbang kembali, lalu berat badannya dibandingkan dengan berat badan kering (<em>dry weight</em>).</li>'
                    .'<li>Pasien diberi edukasi mengenai pembatasan cairan, makanan, obat, perawatan akses vaskular, serta tanda bahaya yang harus segera dilaporkan.</li>'
                    .'</ul>',
                'sort_order' => 1,
            ],

            [
                'question' => 'Mengapa pasien hemodialisis bisa tiba-tiba drop atau lemas saat menjalani terapi?',
                'short_answer' => 'Istilah "drop" menggambarkan pasien yang tiba-tiba lemas, pusing, mual, berkeringat, penurunan kesadaran, atau tekanan darahnya turun. Penyebab paling penting adalah hipotensi intradialisis (Kanbay et al., 2020; Kementerian Kesehatan RI, 2023).',
                'full_answer' => '<p>Istilah "drop" biasanya digunakan untuk menggambarkan pasien yang tiba-tiba menjadi lemas, pusing, mual, berkeringat, mengalami penurunan kesadaran, atau tekanan darahnya turun. Salah satu penyebab paling penting selama hemodialisis adalah <em>intradialytic hypotension</em> (IDH) atau hipotensi intradialisis (Kanbay et al., 2020; Kementerian Kesehatan RI, 2023).</p>'
                    .'<h3>Penyebab yang perlu diketahui</h3>'
                    .'<ol>'
                    .'<li><strong>Tekanan darah turun karena cairan dikeluarkan terlalu banyak atau terlalu cepat.</strong> Hemodialisis menggunakan proses ultrafiltrasi untuk mengeluarkan cairan dari tubuh. Jika cairan dikeluarkan lebih cepat daripada kemampuan tubuh mengisi kembali volume darah dari jaringan, volume sirkulasi dapat menurun sehingga tekanan darah ikut turun. Akibatnya pasien dapat mengalami pusing, lemas, mual, muntah, sakit kepala, kram otot, serta hampir pingsan atau pingsan.</li>'
                    .'<li><strong>Berat badan naik terlalu banyak sebelum dialisis.</strong> Jika pasien mengonsumsi terlalu banyak cairan atau garam di antara jadwal dialisis, cairan dapat menumpuk. Ketika pasien datang dengan kelebihan cairan yang banyak, mesin harus mengeluarkan cairan lebih banyak dalam satu sesi. Hal ini dapat meningkatkan risiko hipotensi dan kram.</li>'
                    .'<li><strong>Tekanan darah pasien memang sudah rendah.</strong> Tekanan darah yang rendah sebelum dialisis merupakan salah satu faktor yang meningkatkan risiko hipotensi intradialisis.</li>'
                    .'<li><strong>Penyakit jantung.</strong> Pasien dengan penyakit kardiovaskular, gangguan fungsi jantung, atau gangguan irama jantung lebih rentan mengalami hipotensi selama dialisis.</li>'
                    .'<li><strong>Gangguan sistem saraf otonom.</strong> Gangguan respons pembuluh darah dan denyut jantung terhadap perubahan volume selama dialisis dapat membuat tubuh sulit mempertahankan tekanan darah.</li>'
                    .'<li><strong>Anemia dan status gizi yang buruk.</strong> Anemia berat, status gizi yang buruk, dan kadar albumin rendah termasuk faktor yang dikaitkan dengan risiko hipotensi intradialisis.</li>'
                    .'<li><strong>Makan saat atau tepat sebelum dialisis.</strong> Makan selama dialisis dapat berkontribusi terhadap hipotensi pada sebagian pasien karena perubahan distribusi aliran darah ke sistem pencernaan. Namun, hubungan ini tidak sederhana dan bukti penelitian masih beragam, sehingga keputusan makan selama dialisis perlu disesuaikan dengan kondisi pasien dan kebijakan unit dialisis.</li>'
                    .'<li><strong>Gangguan elektrolit.</strong> Pasien hemodialisis perlu memperhatikan terutama kalium. Kalium yang terlalu tinggi atau terlalu rendah dapat menyebabkan gangguan irama jantung yang serius.</li>'
                    .'</ol>'
                    .'<h3>Jika pasien benar-benar tiba-tiba drop</h3>'
                    .'<p>Jika pasien hemodialisis tiba-tiba mengalami penurunan kesadaran, sesak berat, nyeri dada, kejang, tekanan darah sangat rendah, atau gangguan irama jantung, kondisi tersebut harus dianggap sebagai keadaan medis yang membutuhkan penanganan segera oleh tenaga kesehatan. Jangan menganggapnya sebagai "efek biasa setelah cuci darah" (Kanbay et al., 2020; Kementerian Kesehatan RI, 2023; NIDDK, n.d.).</p>',
                'sort_order' => 2,
            ],

            [
                'question' => 'Makanan apa yang perlu dibatasi atau dihindari oleh pasien hemodialisis?',
                'short_answer' => 'Pembatasan makanan pada pasien hemodialisis terutama berkaitan dengan natrium (garam), kalium, fosfor, dan cairan (NIDDK, n.d.).',
                'full_answer' => '<p>Pembatasan makanan pada pasien hemodialisis terutama berkaitan dengan natrium atau garam, kalium, fosfor, dan cairan (NIDDK, n.d.).</p>'
                    .'<h3>Makanan tinggi natrium atau garam</h3>'
                    .'<p>Sebaiknya dibatasi:</p>'
                    .'<ul>'
                    .'<li>makanan instan dan mi instan;</li>'
                    .'<li>keripik;</li>'
                    .'<li>makanan kaleng dan makanan beku (<em>processed food</em>);</li>'
                    .'<li>makanan cepat saji;</li>'
                    .'<li>daging olahan, seperti sosis, nugget, dan bacon;</li>'
                    .'<li>makanan dengan banyak kecap atau saus;</li>'
                    .'<li>makanan yang sangat asin.</li>'
                    .'</ul>'
                    .'<p>Natrium yang tinggi dapat meningkatkan rasa haus sehingga pasien minum lebih banyak. Akibatnya, cairan lebih mudah menumpuk di antara jadwal dialisis. Jangan sembarangan mengganti garam dengan <em>salt substitute</em>, karena beberapa produk menggunakan <em>potassium chloride</em> yang dapat meningkatkan asupan kalium (NIDDK, n.d.).</p>'
                    .'<h3>Makanan tinggi kalium</h3>'
                    .'<p>Kalium sangat penting diperhatikan karena kadar kalium yang terlalu tinggi dapat memengaruhi irama jantung dan, dalam kondisi berat, dapat mengancam nyawa. Contoh makanan yang tinggi kalium dan sering perlu dibatasi bila kadar kalium pasien tinggi (NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li>pisang, alpukat, kiwi, melon, dan buah kering;</li>'
                    .'<li>jeruk atau jus jeruk;</li>'
                    .'<li>tomat, kentang, dan ubi;</li>'
                    .'<li>beberapa jenis kacang-kacangan.</li>'
                    .'</ul>'
                    .'<p>Namun, bukan berarti semua pasien hemodialisis sama sekali tidak boleh mengonsumsi makanan tersebut. Jumlah yang diperbolehkan bergantung pada kadar kalium darah dan instruksi ahli gizi ginjal (NIDDK, n.d.).</p>'
                    .'<h3>Makanan tinggi fosfor</h3>'
                    .'<p>Fosfor yang terlalu tinggi dalam darah dapat mengganggu kesehatan tulang dan berhubungan dengan pengendapan kalsium pada pembuluh darah. Yang perlu diperhatikan antara lain (NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li>susu, keju, dan produk susu lainnya;</li>'
                    .'<li>kacang-kacangan dan selai kacang;</li>'
                    .'<li>daging olahan dan makanan kemasan (<em>processed food</em>);</li>'
                    .'<li>minuman kola dan beberapa makanan cepat saji.</li>'
                    .'</ul>'
                    .'<p>Yang sangat penting adalah membaca label makanan dan memperhatikan bahan tambahan yang mengandung "phos", karena fosfat tambahan pada makanan dapat diserap dengan sangat baik oleh tubuh (NIDDK, n.d.).</p>'
                    .'<h3>Cairan juga perlu diperhatikan</h3>'
                    .'<p>Hal ini sering terlupakan. Pasien hemodialisis bukan hanya perlu memperhatikan air putih, tetapi makanan dan minuman yang mengandung banyak air juga dihitung sebagai asupan cairan. Contohnya (NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li>air putih, teh, dan kopi;</li>'
                    .'<li>susu dan sup;</li>'
                    .'<li>es krim, puding, dan gelatin;</li>'
                    .'<li>minuman lainnya serta beberapa makanan yang kandungan airnya tinggi.</li>'
                    .'</ul>'
                    .'<p>Jumlah cairan yang boleh dikonsumsi berbeda pada setiap pasien, salah satunya bergantung pada jumlah urine yang masih diproduksi (NIDDK, n.d.).</p>',
                'sort_order' => 3,
            ],
            [
                'question' => 'Makanan apa yang boleh dan dianjurkan bagi pasien hemodialisis?',
                'short_answer' => 'Pilihan makanan pasien hemodialisis diarahkan pada sumber protein berkualitas, buah-buahan, dan sayuran yang disesuaikan dengan hasil pemeriksaan laboratorium (NIDDK, n.d.).',
                'full_answer' => '<p>Pilihan makanan pasien hemodialisis diarahkan pada sumber protein berkualitas, buah-buahan, dan sayuran yang disesuaikan dengan hasil pemeriksaan laboratorium (NIDDK, n.d.).</p>'
                    .'<h3>Sumber protein berkualitas</h3>'
                    .'<p>Pilihan yang dianjurkan antara lain:</p>'
                    .'<ol>'
                    .'<li>telur;</li>'
                    .'<li>ikan;</li>'
                    .'<li>ayam;</li>'
                    .'<li>daging segar dengan porsi sesuai kebutuhan;</li>'
                    .'<li>protein nabati sesuai toleransi dan hasil laboratorium.</li>'
                    .'</ol>'
                    .'<p>Pasien hemodialisis umumnya justru membutuhkan protein yang cukup, karena hemodialisis dapat menyebabkan kehilangan protein. NIDDK merekomendasikan sumber protein berkualitas seperti daging, unggas, ikan, dan telur (NIDDK, n.d.).</p>'
                    .'<h3>Buah yang umumnya lebih rendah kalium</h3>'
                    .'<p>Dalam jumlah yang sesuai dengan kebutuhan pasien, pilihan buah dapat mencakup:</p>'
                    .'<ol>'
                    .'<li>apel;</li>'
                    .'<li>anggur;</li>'
                    .'<li>beri-berian (<em>berries</em>);</li>'
                    .'<li>buah lain yang sesuai dengan hasil pemeriksaan kalium.</li>'
                    .'</ol>'
                    .'<p>National Kidney Foundation (NKF) juga memberikan contoh apel, beri-berian, dan anggur sebagai pilihan yang lebih rendah fosfor dibanding sejumlah makanan tertentu (NIDDK, n.d.).</p>'
                    .'<h3>Sayuran</h3>'
                    .'<p>Pilihan sayuran harus disesuaikan dengan kadar kalium. Beberapa sayuran yang sering digunakan dalam pola makan ginjal antara lain (NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li>wortel;</li>'
                    .'<li>mentimun;</li>'
                    .'<li>buncis;</li>'
                    .'<li>jagung.</li>'
                    .'</ul>'
                    .'<p>Porsi sayuran tetap perlu diperhatikan.</p>',
                'sort_order' => 4,
            ],

            [
                'question' => 'Apa yang terjadi pada tubuh sehingga pasien memerlukan hemodialisis?',
                'short_answer' => 'Hemodialisis diberikan ketika fungsi ginjal sudah menurun berat sehingga ginjal tidak mampu menjalankan fungsi ekskresi dan pengaturan tubuh secara memadai (Kementerian Kesehatan RI, 2023).',
                'full_answer' => '<p>Hemodialisis merupakan salah satu bentuk terapi pengganti ginjal yang diberikan ketika fungsi ginjal sudah menurun berat, sehingga ginjal tidak mampu menjalankan fungsi ekskresi dan pengaturannya secara memadai. Dalam konteks ini, pasien hemodialisis umumnya mengalami penyakit ginjal kronik tahap lanjut atau gagal ginjal, meskipun hemodialisis juga dapat digunakan pada kondisi tertentu seperti gangguan ginjal akut (Kementerian Kesehatan RI, 2023).</p>'
                    .'<h3>1. Terjadinya kerusakan ginjal</h3>'
                    .'<p>Penyakit ginjal kronik dapat disebabkan oleh berbagai kondisi, antara lain hipertensi, diabetes melitus, glomerulonefritis, penyakit sistemik, kelainan bawaan atau genetik, serta penyakit atau sumbatan saluran kemih. Kementerian Kesehatan menyebutkan bahwa pada pasien dewasa, penyebab penyakit ginjal kronik yang paling banyak adalah diabetes melitus dan hipertensi (Kementerian Kesehatan RI, 2023).</p>'
                    .'<p>Kerusakan ginjal yang berlangsung terus-menerus menyebabkan jumlah jaringan ginjal yang berfungsi semakin berkurang. Ginjal sebenarnya memiliki kemampuan beradaptasi dengan meningkatkan filtrasi pada bagian yang masih berfungsi, yang disebut hiperfiltrasi adaptif. Namun, apabila kerusakan terus berlanjut, mekanisme kompensasi tersebut tidak lagi mampu mempertahankan fungsi ginjal secara normal (Kementerian Kesehatan RI, 2023).</p>'
                    .'<h3>2. Penurunan laju filtrasi glomerulus (eGFR)</h3>'
                    .'<p>Seiring perjalanan penyakit ginjal kronik, terjadi penurunan laju filtrasi glomerulus (eGFR). Nilai eGFR digunakan untuk menggambarkan kemampuan ginjal dalam menyaring darah (Kementerian Kesehatan RI, 2023).</p>'
                    .'<p>Menurut Pedoman Nasional Pelayanan Kedokteran (PNPK) Kementerian Kesehatan 2023, penyakit ginjal kronik didefinisikan sebagai kelainan struktur atau fungsi ginjal yang menetap selama 3 bulan atau lebih, dengan atau tanpa penurunan eGFR. Penyakit ini diklasifikasikan berdasarkan kategori GFR, mulai dari G1 hingga G5, dengan G5 berada pada eGFR 15 mL/menit/1,73 m&sup2; atau kurang (Kementerian Kesehatan RI, 2023).</p>'
                    .'<h3>3. Penurunan kemampuan ginjal membuang zat sisa</h3>'
                    .'<p>Ketika fungsi filtrasi semakin menurun, ginjal tidak mampu mengeluarkan zat sisa metabolisme secara optimal. Akibatnya, zat-zat tersebut menumpuk dalam darah dan menyebabkan kondisi uremia. Manifestasi uremik yang dapat muncul antara lain (Kementerian Kesehatan RI, 2023):</p>'
                    .'<ul>'
                    .'<li>kehilangan nafsu makan;</li>'
                    .'<li>mual dan muntah;</li>'
                    .'<li>gatal;</li>'
                    .'<li>gangguan saraf dan gangguan konsentrasi;</li>'
                    .'<li>kelelahan;</li>'
                    .'<li>gangguan sistem saraf yang berat pada kondisi tertentu.</li>'
                    .'</ul>'
                    .'<h3>4. Gangguan keseimbangan cairan dan elektrolit</h3>'
                    .'<p>Penurunan fungsi ginjal juga mengganggu kemampuan tubuh mempertahankan keseimbangan cairan dan elektrolit. Pasien dapat mengalami kelebihan volume cairan, hiperkalemia, dan asidosis metabolik. Selain itu, penyakit ginjal kronik lanjut dapat disertai hipertensi, anemia, gangguan mineral dan tulang, serta penyakit kardiovaskular (Kementerian Kesehatan RI, 2023).</p>'
                    .'<h3>5. Gagal ginjal dan kebutuhan terapi pengganti ginjal</h3>'
                    .'<p>Apabila kerusakan ginjal terus berlangsung hingga fungsi ginjal tidak lagi mampu memenuhi kebutuhan tubuh, pasien dapat masuk ke penyakit ginjal tahap akhir. Pada kondisi tersebut diperlukan terapi pengganti ginjal, salah satunya hemodialisis (Kementerian Kesehatan RI, 2023).</p>'
                    .'<p>Hemodialisis bekerja dengan menggantikan sebagian fungsi ginjal, terutama mengeluarkan zat sisa metabolisme dan kelebihan cairan dari darah, serta membantu mempertahankan keseimbangan elektrolit dan asam-basa (Kementerian Kesehatan RI, 2023).</p>'
                    .'<p>Alur tersebut sesuai dengan PNPK Kementerian Kesehatan 2023 yang menjelaskan bahwa kerusakan ginjal menyebabkan penurunan eGFR, sehingga kemampuan ginjal mengeluarkan toksin menurun dan dapat menimbulkan manifestasi uremik, kelebihan cairan, hiperkalemia, asidosis metabolik, hipertensi, anemia, dan komplikasi lainnya (Kementerian Kesehatan RI, 2023).</p>',
                'sort_order' => 5,
            ],

            [
                'question' => 'Apa perbedaan ginjal sehat dengan ginjal pasien yang memerlukan hemodialisis?',
                'short_answer' => 'Pasien yang menjalani hemodialisis tidak berarti ginjalnya pasti berubah bentuk atau mengecil. Yang terutama mengalami masalah adalah fungsi ginjalnya (Kementerian Kesehatan RI, 2023).',
                'full_answer' => '<p>Pasien yang menjalani hemodialisis tidak berarti ginjalnya pasti berubah bentuk atau mengecil. Yang terutama mengalami masalah adalah fungsi ginjalnya (Kementerian Kesehatan RI, 2023).</p>'
                    .'<h3>Ginjal sehat</h3>'
                    .'<p>Ginjal merupakan organ yang berperan penting dalam mempertahankan keseimbangan internal tubuh. Secara anatomi, ginjal berbentuk menyerupai kacang dan terdapat sepasang, yaitu ginjal kanan dan ginjal kiri (NIDDK, n.d.).</p>'
                    .'<p>Di dalam ginjal terdapat struktur yang menjalankan fungsi penyaringan darah. Salah satu bagian pentingnya adalah nefron, yaitu unit fungsional ginjal (NIDDK, n.d.).</p>'
                    .'<p>Ginjal sehat memiliki beberapa fungsi utama, yaitu (NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li><strong>Menyaring darah.</strong> Darah disaring melalui glomerulus sebagai bagian dari nefron.</li>'
                    .'<li><strong>Membuang zat sisa metabolisme.</strong> Zat sisa yang tidak dibutuhkan tubuh dikeluarkan melalui urine.</li>'
                    .'<li><strong>Mengatur keseimbangan cairan.</strong> Ginjal membantu mengatur jumlah air yang dipertahankan atau dikeluarkan tubuh.</li>'
                    .'<li><strong>Mengatur elektrolit.</strong> Ginjal berperan menjaga keseimbangan berbagai mineral dan elektrolit dalam tubuh.</li>'
                    .'<li><strong>Menjaga keseimbangan asam-basa.</strong> Ginjal membantu mempertahankan kondisi asam-basa tubuh.</li>'
                    .'<li><strong>Memiliki fungsi hormonal.</strong> Ginjal juga berperan dalam berbagai fungsi hormonal, termasuk yang berkaitan dengan produksi sel darah merah dan metabolisme mineral.</li>'
                    .'</ul>'
                    .'<h3>Ginjal pada pasien yang memerlukan hemodialisis</h3>'
                    .'<p>Pada pasien yang memerlukan hemodialisis, tidak tepat jika dikatakan bahwa bentuk ginjalnya pasti berbeda dari ginjal sehat (Kementerian Kesehatan RI, 2023).</p>'
                    .'<p>Perubahan yang lebih penting adalah penurunan fungsi ginjal. Penyakit ginjal kronik dapat berupa kelainan struktur maupun fungsi ginjal dan berkembang secara progresif hingga gagal ginjal (Kementerian Kesehatan RI, 2023).</p>'
                    .'<p>Pada beberapa penyakit ginjal kronik, pemeriksaan pencitraan seperti USG dapat menunjukkan perubahan struktur ginjal. Namun, ukuran atau bentuk ginjal saja tidak dapat menjadi dasar untuk menentukan apakah seseorang membutuhkan hemodialisis. Penentuan kondisi penyakit ginjal kronik dilakukan berdasarkan berbagai pemeriksaan, termasuk (Kementerian Kesehatan RI, 2023):</p>'
                    .'<ul>'
                    .'<li>pemeriksaan fungsi ginjal dan eGFR;</li>'
                    .'<li>pemeriksaan urine, kadar kreatinin, serta albuminuria atau proteinuria;</li>'
                    .'<li>pemeriksaan klinis dan pemeriksaan penunjang lainnya.</li>'
                    .'</ul>'
                    .'<p>Kementerian Kesehatan juga menyebutkan bahwa evaluasi penyakit ginjal kronik dapat mencakup urinalisis, penilaian proteinuria, USG ginjal, serta pemeriksaan fungsi ginjal (Kementerian Kesehatan RI, 2023).</p>'
                    .'<h3>Perbandingan sederhana</h3>'
                    .'<table>'
                    .'<thead><tr><th>Ginjal sehat</th><th>Ginjal pada pasien yang membutuhkan hemodialisis</th></tr></thead>'
                    .'<tbody>'
                    .'<tr><td>Fungsi filtrasi masih baik</td><td>Fungsi filtrasi mengalami penurunan berat</td></tr>'
                    .'<tr><td>Mampu membuang zat sisa</td><td>Pembuangan zat sisa tidak optimal</td></tr>'
                    .'<tr><td>Mampu mengatur cairan</td><td>Dapat terjadi kelebihan cairan</td></tr>'
                    .'<tr><td>Mampu mengatur elektrolit</td><td>Dapat terjadi gangguan elektrolit</td></tr>'
                    .'<tr><td>Mampu mempertahankan keseimbangan asam-basa</td><td>Dapat terjadi asidosis metabolik</td></tr>'
                    .'<tr><td>Fungsi ginjal dapat memenuhi kebutuhan tubuh</td><td>Fungsi ginjal tidak lagi mencukupi sehingga dapat membutuhkan terapi pengganti ginjal</td></tr>'
                    .'</tbody>'
                    .'</table>'
                    .'<h3>Pesan utama untuk pasien</h3>'
                    .'<p>Yang membedakan ginjal sehat dengan ginjal pada pasien yang membutuhkan hemodialisis terutama adalah kemampuan fungsinya dalam menyaring darah dan menjaga keseimbangan tubuh, bukan hanya bentuk ginjalnya (Kementerian Kesehatan RI, 2023).</p>',
                'sort_order' => 6,
            ],

            [
                'question' => 'Kapan hemodialisis dapat dihentikan?',
                'short_answer' => 'Perlu dibedakan antara hemodialisis pada gagal ginjal kronik yang umumnya berkelanjutan dan hemodialisis pada gangguan ginjal akut yang dapat bersifat sementara (Kementerian Kesehatan RI, 2023; NIDDK, n.d.).',
                'full_answer' => '<p>Untuk menjawab pertanyaan ini, perlu dibedakan antara hemodialisis pada gagal ginjal kronik dan hemodialisis pada gangguan ginjal akut (Kementerian Kesehatan RI, 2023; NIDDK, n.d.).</p>'
                    .'<h3>Pada penyakit ginjal kronik</h3>'
                    .'<p>Pada pasien dengan penyakit ginjal kronik tahap akhir, hemodialisis biasanya merupakan terapi pengganti ginjal yang dilakukan secara berkelanjutan. Hemodialisis tidak menyembuhkan kerusakan ginjal kronik, tetapi menggantikan sebagian fungsi ginjal yang sudah tidak mampu dilakukan secara memadai (Kementerian Kesehatan RI, 2023; NIDDK, n.d.).</p>'
                    .'<p>Karena itu, hemodialisis pada penyakit ginjal kronik tidak dihentikan hanya karena pasien merasa lebih sehat setelah menjalani beberapa kali dialisis (Kementerian Kesehatan RI, 2023; NIDDK, n.d.).</p>'
                    .'<p>PNPK Kementerian Kesehatan 2023 menjelaskan bahwa keputusan memulai dialisis tidak hanya berdasarkan satu nilai eGFR, tetapi terutama mempertimbangkan tanda dan gejala gagal ginjal serta kondisi klinis pasien. Indikasi tersebut antara lain gejala akibat gagal ginjal, gangguan asam-basa atau elektrolit, ketidakmampuan mengontrol volume cairan atau tekanan darah, penurunan status gizi yang tidak responsif terhadap intervensi, serta gangguan kognitif (Kementerian Kesehatan RI, 2023; NIDDK, n.d.).</p>'
                    .'<p>Hemodialisis dapat tidak lagi diperlukan apabila pasien beralih ke terapi pengganti ginjal lainnya. Salah satu contohnya adalah transplantasi ginjal. Jika transplantasi berhasil dan ginjal donor berfungsi dengan baik, pasien tidak lagi membutuhkan hemodialisis sebagai terapi pengganti fungsi ginjal (Kementerian Kesehatan RI, 2023; NIDDK, n.d.).</p>'
                    .'<h3>Pada gangguan ginjal akut</h3>'
                    .'<p>Kondisi ini berbeda dengan penyakit ginjal kronik. Pada gangguan ginjal akut (<em>acute kidney injury</em>), kerusakan fungsi ginjal dapat bersifat sementara. Karena itu, sebagian pasien mungkin membutuhkan hemodialisis hanya untuk sementara waktu. Jika fungsi ginjal kemudian pulih dan mampu mempertahankan kebutuhan tubuh, terapi pengganti ginjal dapat dihentikan berdasarkan penilaian dokter (KDIGO, 2012; Babroudi et al., 2024).</p>'
                    .'<p>Secara sederhana: penyakit ginjal kronik bersifat menetap sehingga hemodialisis dapat berlangsung jangka panjang, sedangkan pada gangguan ginjal akut hemodialisis dapat bersifat sementara dan dihentikan jika fungsi ginjal pulih (KDIGO, 2012; Babroudi et al., 2024).</p>'
                    .'<h3>Penghentian satu sesi dialisis</h3>'
                    .'<p>Pertanyaan "kapan satu sesi hemodialisis dihentikan" berbeda dengan "kapan pasien berhenti menjalani hemodialisis". Dalam kondisi tertentu, satu sesi hemodialisis dapat dihentikan segera apabila terjadi komplikasi serius selama proses dialisis. Sebagai contoh, PNPK Kementerian Kesehatan menjelaskan bahwa pada reaksi hipersensitivitas berat terhadap komponen sirkuit dialisis, dialisis harus segera dihentikan (Kementerian Kesehatan RI, 2023; KDIGO, 2012).</p>'
                    .'<p>Dengan demikian, terdapat tiga konteks penghentian (Kementerian Kesehatan RI, 2023; KDIGO, 2012):</p>'
                    .'<ol>'
                    .'<li>Berhenti satu sesi hemodialisis karena komplikasi akut, yang merupakan keputusan medis selama proses dialisis.</li>'
                    .'<li>Berhenti menjalani hemodialisis karena fungsi ginjal pulih, terutama pada kondisi seperti gangguan ginjal akut.</li>'
                    .'<li>Berhenti hemodialisis karena beralih ke terapi lain, misalnya transplantasi ginjal.</li>'
                    .'</ol>',
                'sort_order' => 7,
            ],
            [
                'question' => 'Bagaimana cara mencegah agar tidak sampai memerlukan hemodialisis?',
                'short_answer' => 'Tidak semua penyakit ginjal dapat dicegah, tetapi risikonya dapat dikurangi dengan menjaga kesehatan dan melakukan deteksi dini (WHO, 2026; Kementerian Kesehatan RI, 2023).',
                'full_answer' => '<p>Tidak semua penyakit ginjal dapat dicegah, tetapi risiko terjadinya penyakit ginjal kronik dan perburukannya dapat dikurangi dengan menjaga kesehatan dan melakukan deteksi dini (WHO, 2026; Kementerian Kesehatan RI, 2023).</p>'
                    .'<h3>Langkah yang dapat dilakukan</h3>'
                    .'<ul>'
                    .'<li><strong>Kendalikan tekanan darah.</strong> Tekanan darah tinggi yang tidak terkontrol dapat meningkatkan risiko kerusakan ginjal. Pemeriksaan tekanan darah secara rutin penting dilakukan, terutama bagi orang yang memiliki hipertensi.</li>'
                    .'<li><strong>Kendalikan gula darah.</strong> Diabetes merupakan salah satu faktor penting yang berhubungan dengan penyakit ginjal. Mengontrol kadar gula darah dapat membantu mengurangi risiko kerusakan ginjal.</li>'
                    .'<li><strong>Terapkan pola hidup sehat.</strong> Melakukan aktivitas fisik secara teratur, menjaga berat badan, mengonsumsi makanan sehat, dan tidak merokok dapat membantu menurunkan risiko penyakit ginjal.</li>'
                    .'<li><strong>Hindari penggunaan obat secara sembarangan.</strong> Obat tertentu dapat memengaruhi fungsi ginjal, terutama jika digunakan tidak sesuai anjuran. Konsultasikan penggunaan obat kepada tenaga kesehatan.</li>'
                    .'<li><strong>Lakukan pemeriksaan ginjal bila berisiko.</strong> Orang dengan diabetes, hipertensi, penyakit jantung, atau faktor risiko lainnya perlu melakukan pemeriksaan fungsi ginjal secara berkala. WHO merekomendasikan pemeriksaan seperti eGFR dan albuminuria untuk deteksi dini pada kelompok berisiko.</li>'
                    .'</ul>',
                'sort_order' => 8,
            ],

            [
                'question' => 'Apakah pasien hemodialisis bisa sembuh?',
                'short_answer' => 'Jawabannya bergantung pada penyebab dan kondisi ginjal pasien (KDIGO, 2012; Babroudi et al., 2024).',
                'full_answer' => '<p>Jawabannya bergantung pada penyebab dan kondisi ginjal pasien (KDIGO, 2012; Babroudi et al., 2024).</p>'
                    .'<h3>Jika hemodialisis dilakukan karena gagal ginjal akut</h3>'
                    .'<p>Pada gangguan ginjal akut (<em>acute kidney injury</em>), kerusakan ginjal dapat bersifat sementara. Sebagian pasien yang membutuhkan dialisis akibat gangguan ginjal akut dapat mengalami pemulihan fungsi ginjal, sehingga akhirnya tidak membutuhkan dialisis lagi (KDIGO, 2012; Babroudi et al., 2024).</p>'
                    .'<p>Sebuah penelitian pada pasien yang menjalani hemodialisis akibat gangguan ginjal akut dan kemudian melanjutkan hemodialisis setelah keluar dari rumah sakit menemukan bahwa 41% pasien mengalami pemulihan fungsi ginjal dalam 90 hari, dengan sebagian besar pemulihan terjadi pada 30 hari pertama. Penelitian dan ulasan terbaru juga menegaskan bahwa pemulihan fungsi ginjal perlu dipantau pada pasien gangguan ginjal akut yang menjalani dialisis (KDIGO, 2012; Babroudi et al., 2024).</p>'
                    .'<h3>Jika sudah mengalami gagal ginjal kronik tahap akhir</h3>'
                    .'<p>Pada gagal ginjal kronik tahap akhir, hemodialisis bukanlah obat yang menyembuhkan ginjal. Hemodialisis berfungsi menggantikan sebagian fungsi ginjal, yaitu membantu membersihkan darah dan membuang kelebihan cairan (KDIGO, 2012; Babroudi et al., 2024).</p>'
                    .'<p>Pilihan terapi untuk gagal ginjal dapat meliputi (WHO, 2026; NIDDK, n.d.):</p>'
                    .'<ul>'
                    .'<li>hemodialisis;</li>'
                    .'<li>dialisis peritoneal;</li>'
                    .'<li>transplantasi ginjal;</li>'
                    .'<li>pada kondisi tertentu, penatalaksanaan konservatif tanpa dialisis atau transplantasi.</li>'
                    .'</ul>',
                'sort_order' => 9,
            ],

            [
                'question' => 'Apa manfaat hemodialisis dan mengapa harus dilakukan secara rutin?',
                'short_answer' => 'Ginjal normal menyaring darah, membuang zat sisa, serta mengatur cairan dan elektrolit. Ketika fungsinya sangat menurun, hemodialisis membantu mengambil alih sebagian fungsi tersebut (NIDDK, n.d.).',
                'full_answer' => '<p>Ginjal normal berfungsi menyaring darah, membuang zat sisa, mengatur cairan dan elektrolit, serta membantu mengontrol tekanan darah. Ketika fungsi ginjal sudah sangat menurun, zat sisa dan cairan dapat menumpuk di dalam tubuh. Hemodialisis membantu mengambil alih sebagian fungsi tersebut (NIDDK, n.d.).</p>'
                    .'<h3>Manfaat hemodialisis</h3>'
                    .'<ul>'
                    .'<li><strong>Membersihkan darah.</strong> Hemodialisis membantu membuang zat sisa metabolisme dari darah.</li>'
                    .'<li><strong>Mengeluarkan kelebihan cairan.</strong> Hemodialisis membantu mengurangi cairan yang menumpuk dalam tubuh.</li>'
                    .'<li><strong>Membantu menjaga keseimbangan mineral.</strong> Hemodialisis membantu mengontrol mineral penting seperti kalium, natrium, dan kalsium.</li>'
                    .'<li><strong>Membantu mengontrol tekanan darah.</strong> Pengaturan cairan dan elektrolit melalui hemodialisis dapat membantu mengontrol tekanan darah.</li>'
                    .'<li><strong>Membantu pasien merasa lebih baik.</strong> Hemodialisis dapat mengurangi masalah akibat penumpukan zat sisa dan cairan, serta membantu pasien merasa lebih baik dan hidup lebih lama.</li>'
                    .'</ul>'
                    .'<h3>Mengapa harus dilakukan secara rutin?</h3>'
                    .'<p>Hemodialisis hanya menggantikan sebagian fungsi ginjal, bukan seluruhnya. Oleh sebab itu, pasien perlu mengikuti jadwal hemodialisis dan anjuran tenaga kesehatan mengenai makanan, cairan, serta obat-obatan (NIDDK, n.d.).</p>',
                'sort_order' => 10,
            ],
        ];


        DB::transaction(function () use ($faqs): void {
            Faq::query()->delete();

            foreach ($faqs as $faq) {
                Faq::query()->create([
                    'question' => $faq['question'],
                    'slug' => Str::slug($faq['question']),
                    'short_answer' => $faq['short_answer'],
                    'full_answer' => $faq['full_answer'],
                    'is_active' => true,
                    'sort_order' => $faq['sort_order'],
                ]);
            }
        });
    }
}
