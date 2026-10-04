# PRD FAQ Hemodialisis

RSUD Dr. M. Yunus Bengkulu  
Versi 1.0 • 4 Oktober 2026

Dokumen ini menjadi acuan pengembangan aplikasi web FAQ edukasi hemodialisis untuk pasien dan pengunjung RSUD Dr. M. Yunus Bengkulu. Sistem menyediakan informasi melalui daftar pertanyaan yang mudah dibaca serta panel admin sederhana untuk mengelola konten. Pengembangan dilaksanakan bertahap atas perintah pemilik proyek; menerima PRD ini tidak berarti mendapat izin untuk langsung membangun seluruh aplikasi.

## 1 Tujuan dan ruang lingkup

Tujuan sistem adalah membantu pengunjung menemukan informasi umum tentang hemodialisis tanpa login dan membantu satu admin memperbarui informasi dengan mudah. Hemodialisis merupakan topik edukasi sistem, bukan nama penyakit. Nama publik aplikasi adalah FAQ Hemodialisis.

Versi pertama mencakup halaman publik, pencarian, accordion jawaban singkat, halaman jawaban lengkap opsional, login admin, dashboard, pengelolaan FAQ, pengaturan urutan melalui drag-and-drop, status aktif atau nonaktif, profil admin, dan reset tampilan publik setelah 60 detik tanpa interaksi.

Versi pertama tidak mencakup kategori, gambar pada jawaban, unggah berkas, registrasi pengunjung maupun admin, akun pasien, rekam medis, diagnosis, chatbot, penilaian medis otomatis, analytics, FAQ populer, role dan permission, riwayat perubahan, activity log, soft delete, atau workflow persetujuan konten. Tidak ada persyaratan tambahan berupa verifikasi tenaga kesehatan sebelum publikasi. Disclaimer edukasi tetap ditampilkan.

Konfigurasi Windows, browser kiosk, perangkat, dan hosting tidak dibahas secara rinci dalam PRD ini. Aplikasi harus dapat digunakan melalui browser biasa dan browser kiosk dengan source code serta build yang sama.

## 2 Pengguna dan alur utama

Pengunjung membuka halaman publik tanpa akun, melihat FAQ aktif sesuai urutan, mencari informasi, membuka jawaban singkat, dan membaca jawaban lengkap jika tersedia. Pengunjung tidak dapat mengubah konten atau mengakses fungsi admin.

Admin masuk menggunakan email dan password. Setelah login, admin dapat melihat ringkasan data, menambah dan mengubah FAQ, mengaktifkan atau menonaktifkan FAQ, mengubah urutan, menghapus permanen setelah konfirmasi, serta mengubah nama, email, dan password sendiri. Semua akun pada tabel users adalah akun admin; versi pertama menggunakan satu akun yang dibuat melalui seeder atas perintah pemilik proyek.

Alur publik: buka daftar FAQ, cari atau pilih pertanyaan, baca jawaban singkat, lalu buka jawaban lengkap bila tersedia. Tombol kembali pada halaman detail membawa pengunjung ke daftar FAQ. Alur admin: login, pilih FAQ, lakukan perubahan, simpan, dan menerima pemberitahuan hasil tindakan.

## 3 Struktur halaman

| Area | Halaman | Fungsi utama |
| --- | --- | --- |
| Publik | Daftar FAQ | Identitas rumah sakit, pencarian, accordion, footer |
| Publik | Detail FAQ | Pertanyaan, jawaban lengkap, tombol kembali |
| Admin | Login | Login email dan password |
| Admin | Dashboard | Total FAQ, aktif, nonaktif, FAQ terbaru diperbarui |
| Admin | FAQ | Cari, filter status, urutkan, tambah, edit, pratinjau, hapus |
| Admin | Form FAQ | Pertanyaan, jawaban singkat, jawaban lengkap, status |
| Admin | Profil | Nama, email, ubah password |

Menu admin terdiri atas Dashboard, FAQ, Profil, dan Logout. Tidak ada menu Kategori atau Settings. Tidak ada tombol login admin di halaman publik; admin membuka alamat /admin secara langsung. Menyembunyikan tombol tersebut bukan pengganti autentikasi.

## 4 Halaman publik

### 4.1 Identitas dan tata letak

Header memuat nama RSUD Dr. M. Yunus Bengkulu dan logo resmi apabila berkasnya diberikan pemilik proyek. AI tidak boleh membuat logo pengganti yang menyerupai identitas resmi. Larangan gambar pada jawaban tidak menghilangkan kebutuhan identitas rumah sakit. Jika logo belum tersedia, gunakan nama rumah sakit sebagai identitas teks.

Judul halaman adalah FAQ Hemodialisis. Pengantar singkat: Temukan informasi umum seputar hemodialisis. Di bawah pengantar terdapat kolom pencarian, lalu daftar pertanyaan dalam satu kolom. Halaman tidak menggunakan kategori, slider, banner promosi, atau panel statistik.

### 4.2 Pencarian

Placeholder pencarian: Cari informasi hemodialisis.... Pencarian dilakukan di frontend terhadap pertanyaan dan jawaban singkat FAQ aktif yang telah diterima dari server. Gunakan pencocokan teks sederhana yang tidak membedakan huruf besar dan kecil, dengan whitespace awal dan akhir diabaikan. Tidak diperlukan request setiap karakter, fuzzy search, mesin pencarian terpisah, atau pencarian pada HTML jawaban lengkap.

Hasil tetap mengikuti urutan FAQ, bukan skor relevansi. Saat kata kunci berubah, tutup accordion yang terbuka. Tombol hapus pencarian mengosongkan kata kunci dan menampilkan seluruh FAQ aktif. Jika tidak ada hasil, tampilkan Tidak ada pertanyaan yang sesuai. Coba kata kunci lain. beserta tindakan Hapus pencarian.

### 4.3 Accordion

Setiap pertanyaan menjadi tombol dengan seluruh area header dapat disentuh. Semua accordion tertutup ketika halaman pertama kali dibuka. Hanya satu accordion terbuka pada satu waktu; menyentuh pertanyaan yang sama menutupnya. Jawaban singkat berupa teks biasa dengan line break yang tetap terbaca.

Tombol Lihat Selengkapnya muncul hanya jika jawaban lengkap memiliki konten yang bermakna setelah sanitasi dan normalisasi. HTML kosong seperti paragraf tanpa isi tidak dihitung sebagai jawaban lengkap. Tombol membuka halaman detail, bukan modal, agar isi yang panjang tetap mudah dibaca.

### 4.4 Halaman detail

Detail memuat identitas rumah sakit, tombol Kembali ke FAQ, pertanyaan sebagai judul, dan jawaban lengkap dengan format teks yang dipertahankan. Tidak perlu mengulang jawaban singkat jika jawaban lengkap sudah menjelaskan topik yang sama. FAQ nonaktif, slug tidak ditemukan, atau FAQ tanpa jawaban lengkap menghasilkan halaman 404 yang ramah dengan tombol kembali ke FAQ.

Halaman publik tidak menampilkan metadata admin, status nonaktif, atau isi draft. FAQ nonaktif harus dicegah dari server, termasuk ketika URL detail diakses langsung.

### 4.5 Footer

Tampilkan disclaimer berikut persis: Informasi pada halaman ini bersifat edukasi umum dan tidak menggantikan konsultasi dengan dokter atau tenaga kesehatan.

Footer dapat memuat nama rumah sakit dan nomor kontak dari konfigurasi aplikasi. Nomor final belum dikunci; jangan menampilkan nomor dugaan. Jika nomor belum diberikan, sembunyikan bagian nomor kontak. Teks disclaimer disimpan dalam komponen aplikasi, bukan tabel database. Nama dan nomor kontak ditempatkan di config/hospital.php, dengan nilai kontak dapat berasal dari environment. Tidak ada formulir settings pada admin.

## 5 Reset tampilan publik

Setelah 60 detik tanpa interaksi, tampilan kembali ke kondisi awal. Pada daftar FAQ: kosongkan pencarian, tutup accordion, tutup dialog publik jika kelak ada, dan gulir ke atas. Pada halaman detail: arahkan ke halaman daftar FAQ dalam keadaan awal. Hindari hard refresh berkala jika reset state sudah cukup.

Interaksi yang memperbarui timer adalah pointerdown, input atau keydown, serta scroll dari pengguna. Hover dan gerakan pointer tanpa tindakan tidak perlu memperbarui timer. Pengguliran yang dipicu reset aplikasi tidak boleh memulai rangkaian reset berulang. Gunakan satu timer yang dikelola dengan jelas dan bersihkan listener jika komponen dilepas. Periksa kembali waktu idle saat halaman aktif lagi karena browser dapat menunda timer di tab yang tidak aktif.

Aturan 60 detik berlaku pada halaman publik dalam versi ini, termasuk ketika dibuka di browser biasa. Aturan tersebut tidak berlaku pada halaman admin agar formulir tidak hilang ketika admin sedang mengerjakan konten. Mengubah cakupan timer membutuhkan keputusan pemilik proyek; AI tidak boleh menambahkan deteksi perangkat atau mode baru secara diam-diam.

## 6 Panel admin

### 6.1 Login dan logout

Login menggunakan email dan password melalui autentikasi session Laravel. Email dipangkas whitespace dan dinormalisasi secara konsisten. Kesalahan login menggunakan pesan umum Email atau password tidak sesuai. Berikan pembatasan percobaan login, misalnya lima kegagalan per menit berdasarkan kombinasi email dan IP, dengan pesan waktu tunggu yang jelas.

Tidak ada registrasi publik, login sosial, atau fitur lupa password via email pada versi pertama. Jika akun terkunci karena lupa password, penanganan dilakukan pemilik proyek melalui prosedur pengelolaan akun saat diperlukan. Logout menggunakan POST, mengakhiri session, dan membawa admin ke halaman login. Browser back setelah logout tidak boleh memberikan akses ke halaman admin yang dilindungi.

### 6.2 Dashboard

Dashboard memuat tiga ringkasan: Total FAQ, FAQ Aktif, dan FAQ Nonaktif. Angka dihitung dari database. Tambahkan tombol Tambah FAQ dan maksimal lima FAQ terbaru diperbarui, dengan pertanyaan, status, waktu perubahan, dan tindakan Edit. Jika belum ada data, tampilkan pesan kosong dan tombol tambah. Tidak ada grafik atau data pengunjung.

### 6.3 Daftar FAQ

Gunakan daftar card administratif dengan drag handle, pertanyaan, badge status, tanggal diperbarui, dan tindakan yang jelas. Sediakan pencarian pertanyaan serta tab Semua, Aktif, dan Nonaktif. Tab Semua menjadi tampilan awal. Pencarian sederhana melalui query server atau filter lokal boleh dipilih sesuai struktur proyek; hasil harus konsisten dan tetap mengikuti urutan FAQ.

Tindakan per FAQ: Edit, Pratinjau, Aktifkan atau Nonaktifkan, serta Hapus Permanen. Pratinjau berada di area admin yang dilindungi dan dapat menampilkan FAQ nonaktif; jangan membuat URL publik draft atau token berbagi. Pratinjau dapat memperlihatkan jawaban singkat serta jawaban lengkap jika tersedia.

Status dapat diubah tanpa menghapus data. FAQ nonaktif hilang dari halaman publik pada request berikutnya. Tampilan publik yang sudah terbuka boleh memakai data sampai dimuat ulang; tidak diperlukan polling atau WebSocket.

### 6.4 Form FAQ

| Field di UI | Jenis input | Ketentuan |
| --- | --- | --- |
| Pertanyaan | Input teks atau textarea pendek | Wajib, maksimal 255 karakter |
| Jawaban Singkat | Textarea teks biasa | Wajib, maksimal 2000 karakter |
| Jawaban Lengkap | Rich-text editor ringan | Opsional, maksimal 50000 karakter HTML |
| Status | Pilihan Aktif atau Nonaktif | Wajib, default Aktif untuk FAQ baru |

Pertanyaan dan jawaban singkat tidak boleh berisi whitespace saja. Jawaban lengkap mendukung paragraf, bold, italic, bullet, numbering, serta tautan yang aman. Tidak ada gambar, unggah berkas, video, embed, iframe, tabel kompleks, atau penyuntingan HTML mentah. Editor dan toolbar harus tetap sederhana.

Admin tidak mengisi slug atau angka urutan. Tombol Simpan menampilkan keadaan proses dan mencegah pengiriman ganda. Jika validasi gagal, tampilkan kesalahan dekat field dan pertahankan input. Jika penyimpanan gagal, jangan tampilkan pesan sukses. Setelah berhasil, kembali ke daftar FAQ dengan pemberitahuan singkat. Tombol Batal kembali ke daftar; beri konfirmasi jika terdapat perubahan yang belum disimpan.

### 6.5 Urutan FAQ

Gunakan satu urutan global untuk seluruh FAQ, termasuk yang nonaktif. Halaman publik menyaring FAQ aktif lalu mengikuti sort_order. Drag-and-drop tersedia hanya pada tab Semua ketika pencarian kosong; saat terfilter, nonaktifkan drag handle dan jelaskan bahwa pengurutan tersedia pada daftar lengkap. Tidak perlu pagination untuk skala awal sembilan FAQ.

Setelah drop, frontend mengirim array ID seluruh FAQ dalam urutan baru. Server memastikan setiap ID valid, tidak duplikat, dan himpunan ID sama dengan daftar lengkap saat itu. Jika data berubah sejak halaman dibuka, tolak permintaan dan minta admin memuat ulang. Pembaruan urutan dilakukan dalam transaction; bila perlu kunci baris agar penyimpanan serentak tidak menghasilkan urutan parsial.

sort_order disimpan sebagai angka berurutan mulai 1. FAQ baru ditempatkan di akhir. Perubahan aktif atau nonaktif tidak mengubah urutan. Setelah penghapusan, urutan dapat dirapikan dalam transaction yang sama. sort_order tidak memiliki unique constraint. Pembacaan selalu memakai sort_order lalu id sebagai penentu kedua. Jika penyimpanan urutan gagal, kembalikan urutan tampilan sebelumnya dan beri pesan kesalahan.

### 6.6 Hapus permanen

Dialog menyebutkan pertanyaan yang akan dihapus dan menjelaskan bahwa penghapusan permanen tidak dapat dibatalkan. Tombol Batal tidak mengubah data. Tombol Hapus Permanen menjalankan DELETE melalui route admin yang dilindungi. Tidak ada trash, restore, atau deleted_at. FAQ yang telah dihapus tidak dapat diakses lagi melalui URL publik maupun pratinjau admin.

### 6.7 Profil

Profil hanya memuat nama dan email, serta formulir ubah password terpisah. Nama wajib, maksimal 100 karakter. Email wajib, format valid, maksimal 255 karakter, dan unik dengan mengabaikan akun sendiri pada validasi update. Perubahan email meminta password saat ini. Ubah password meminta password saat ini, password baru minimal 12 karakter, dan konfirmasi yang cocok.

Password disimpan dengan hashing Laravel. Password saat ini tidak boleh ditampilkan atau dicatat. Tidak ada foto profil, nomor telepon admin, alamat, atau atribut tambahan. Setelah perubahan password, regenerasi session yang aktif dan rotasi remember_token jika digunakan.

## 7 Rancangan database

Database menggunakan MySQL dan utf8mb4. Nama database yang disarankan adalah faq_hemodialisis. Dua tabel domain adalah users dan faqs. Tabel sistem Laravel hanya dipakai sesuai driver dan fitur aktual; jangan menambah tabel jobs, cache, atau reset password hanya sebagai persyaratan domain.

### 7.1 Tabel users

| Field | Tipe | Constraint atau nilai awal |
| --- | --- | --- |
| id | BIGINT UNSIGNED | Primary key, auto increment |
| name | VARCHAR 100 | NOT NULL |
| email | VARCHAR 255 | NOT NULL, UNIQUE |
| password | VARCHAR 255 | NOT NULL, hash |
| remember_token | VARCHAR 100 | NULLABLE, mengikuti autentikasi Laravel |
| created_at | TIMESTAMP | Timestamp Laravel |
| updated_at | TIMESTAMP | Timestamp Laravel |

Tidak ada role, is_admin, permissions, atau user_type. Pengunjung tidak disimpan pada tabel ini. Kredensial admin tidak ditulis di PRD, source code, atau log. Seeder admin kelak mengambil kredensial awal dari input atau environment yang disepakati ketika tahap tersebut diminta.

### 7.2 Tabel faqs

| Field | Tipe | Constraint atau nilai awal |
| --- | --- | --- |
| id | BIGINT UNSIGNED | Primary key, auto increment |
| question | VARCHAR 255 | NOT NULL |
| slug | VARCHAR 255 | NOT NULL, UNIQUE |
| short_answer | TEXT | NOT NULL, teks biasa |
| full_answer | LONGTEXT | NULLABLE, HTML yang telah disanitasi |
| is_active | BOOLEAN | NOT NULL, default TRUE |
| sort_order | INT UNSIGNED | NOT NULL, default 0; aplikasi menetapkan posisi mulai 1 |
| created_at | TIMESTAMP | Timestamp Laravel |
| updated_at | TIMESTAMP | Timestamp Laravel |

Tambahkan index gabungan is_active, sort_order, id untuk pembacaan publik. Slug dan email memiliki unique index. Tidak ada category_id, image, created_by, updated_by, deleted_at, atau foreign key antara kedua tabel domain. Jawaban singkat dan jawaban lengkap merupakan atribut satu FAQ dan tidak perlu tabel tersendiri.

Normalisasi dilakukan pada atribut terstruktur: setiap record mewakili satu entitas, tidak ada kelompok kolom berulang atau ketergantungan transitif pada atribut domain lain. HTML jawaban lengkap diperlakukan sebagai satu dokumen konten. Tidak perlu memecah paragraf, format teks, atau tautan ke tabel tersendiri untuk scope ini.

### 7.3 Slug dan konsistensi data

Slug dibuat otomatis saat FAQ pertama kali disimpan. Jika slug dasar telah digunakan, tambahkan suffix yang aman; unique constraint database tetap menjadi perlindungan akhir terhadap benturan. Berikan fallback jika teks pertanyaan tidak menghasilkan slug. Pertahankan slug ketika pertanyaan diedit agar URL tetap stabil. Admin tidak perlu mengedit slug.

Gunakan cast boolean untuk is_active dan integer untuk sort_order. Jawaban lengkap yang kosong setelah normalisasi disimpan sebagai NULL. Sanitasi dijalankan sebelum penyimpanan, bukan hanya ketika rendering. Pada render jawaban lengkap, hanya HTML hasil sanitasi yang boleh ditampilkan sebagai HTML; pertanyaan dan jawaban singkat selalu di-escape.

### 7.4 Migration dan seeder

Migration dan seeder baru dibuat ketika diminta pemilik proyek. Periksa migration bawaan users agar tidak membuat tabel duplikat. users dan faqs tidak saling bergantung; tidak diperlukan migration relasi. Jika menggunakan database session, tabel sessions adalah tabel infrastruktur. Relasi atau index bawaannya tidak mengubah keputusan bahwa faqs tidak berelasi dengan users.

Seeder admin membuat satu akun secara idempotent dan tidak mereset password akun yang sudah ada pada setiap eksekusi. Jangan gunakan password tetap yang lemah. Seeder FAQ juga tidak boleh menggandakan atau menimpa konten admin saat dijalankan kembali. Identifikasi record awal memakai slug stabil dan hindari pembaruan otomatis terhadap konten yang sudah dikelola admin.

Jika jawaban asli belum diberikan saat seeder diminta, gunakan sembilan pertanyaan pada bagian berikut dengan short_answer Jawaban belum tersedia., full_answer NULL, dan is_active FALSE. Data tersebut merupakan placeholder pengembangan. Jangan membuat jawaban medis sendiri atau mempublikasikan placeholder sebagai informasi pasien. Ketentuan ini bukan workflow verifikasi medis; hanya memastikan seeder tidak mengarang konten yang belum diberikan.

## 8 Daftar pertanyaan awal

1. Bagaimana prosedur hemodialisis dilakukan?
2. Mengapa pasien dapat merasa lemas atau mengalami penurunan kondisi saat atau setelah hemodialisis?
3. Makanan apa yang dianjurkan dan perlu dihindari oleh pasien hemodialisis?
4. Apa yang terjadi pada tubuh ketika fungsi ginjal menurun hingga memerlukan hemodialisis?
5. Bagaimana perbedaan ginjal sehat dengan ginjal yang mengalami gangguan hingga memerlukan hemodialisis?
6. Dalam kondisi apa hemodialisis dapat dihentikan?
7. Bagaimana cara mencegah gangguan ginjal yang dapat menyebabkan kebutuhan hemodialisis?
8. Apakah pasien yang menjalani hemodialisis dapat sembuh?
9. Apa manfaat dan alasan dilakukannya hemodialisis?

Nomor 5 tetap menjadi pertanyaan yang dapat dijawab dengan teks. Fitur gambar tidak dibuat pada versi pertama. Daftar ini adalah struktur topik awal; jumlah FAQ tidak dibatasi menjadi sembilan. Isi jawaban akan diberikan pemilik proyek secara terpisah.

## 9 Arsitektur dan tanggung jawab kode

Baseline teknologi: Laravel 13, PHP minimal 8.3, MySQL, Blade, Tailwind CSS, Vite, serta JavaScript ringan untuk interaksi. Alpine.js dapat digunakan bila cocok dengan proyek. Tidak diperlukan SPA terpisah, React, Vue, Redis, queue, API publik, atau microservice. Jika proyek sudah memakai versi Laravel yang berbeda, laporkan kondisi aktual dan minta keputusan sebelum upgrade; jangan memasang ulang proyek.

Sebelum perubahan, periksa composer.json, package.json, struktur proyek, migration, dan konfigurasi yang relevan tanpa membocorkan nilai rahasia. Pilih dependensi editor dan drag-and-drop yang ringan pada tahap terkait, periksa kompatibilitas, dan jelaskan pilihannya. Dependensi tidak dipasang saat baru menerima PRD.

Model User menangani akun admin. Model Faq menangani atribut, cast, dan scope aktif atau berurutan. Controller publik hanya membaca FAQ aktif. Controller admin menangani dashboard, CRUD, pratinjau, status, pengurutan, dan profil. Gunakan Form Request untuk validasi. Logika sanitasi dan pengurutan dapat dipisahkan ke kelas kecil jika membantu; tidak perlu repository atau service untuk setiap operasi CRUD sederhana.

Pisahkan layout publik dan admin. Komponen yang masuk akal: identitas rumah sakit, footer publik, kolom pencarian, accordion, notifikasi, badge status, serta dialog konfirmasi. Semua route penulisan memakai autentikasi dan perlindungan CSRF. Endpoint mutasi tidak boleh menggunakan GET.

### 9.1 Rancangan route

| Method | URL | Fungsi dan akses |
| --- | --- | --- |
| GET | / | Daftar FAQ aktif, publik |
| GET | /faq/{slug} | Detail FAQ aktif dengan jawaban lengkap, publik |
| GET dan POST | /admin/login | Form dan proses login, guest |
| POST | /admin/logout | Logout, auth |
| GET | /admin | Dashboard, auth |
| GET | /admin/faqs | Daftar FAQ, auth |
| GET | /admin/faqs/create | Form tambah, auth |
| POST | /admin/faqs | Simpan baru, auth |
| GET | /admin/faqs/{faq}/edit | Form edit, auth |
| PUT atau PATCH | /admin/faqs/{faq} | Simpan perubahan, auth |
| PATCH | /admin/faqs/{faq}/status | Ubah status, auth |
| PUT | /admin/faqs/reorder | Simpan seluruh urutan, auth |
| GET | /admin/faqs/{faq}/preview | Pratinjau aktif dan nonaktif, auth |
| DELETE | /admin/faqs/{faq} | Hapus permanen, auth |
| GET | /admin/profile | Form profil, auth |
| PATCH | /admin/profile | Perbarui nama atau email, auth |
| PUT | /admin/profile/password | Ubah password, auth |

Gunakan nama route konsisten dengan prefix public atau admin. Definisikan route statis create dan reorder sebelum parameter dinamis, dan batasi parameter ID admin sebagai angka. Gunakan route model binding ID di admin serta slug pada publik. URL tidak boleh ditulis berulang secara manual ketika helper route tersedia.

## 10 Arah visual dan responsive

Tampilan menggunakan nuansa hijau yang hangat, bersih, tenang, profesional, dan lega. Jangan memakai biru sebagai warna utama, glassmorphism berlebihan, gradient ramai, shadow tebal, atau dashboard generik yang penuh metrik.

| Peran warna | Nilai |
| --- | --- |
| Primary hijau | #236B5D |
| Background hijau ringan | #DDEDE7 |
| Background halaman | #F8F7F3 |
| Surface | #FFFFFF |
| Teks utama | #26332F |
| Accent hangat terbatas | #D97757 |

Gunakan merah secara semantik untuk tindakan berbahaya dan pesan kesalahan. Warna accent tidak otomatis cocok sebagai warna teks kecil; periksa kontras. Pertahankan warna logo resmi jika berkas tersedia.

Publik menggunakan satu kolom dengan lebar konten sekitar 960 sampai 1120 piksel pada layar besar. Pada desktop atau kiosk, pertanyaan sekitar 22 sampai 26 piksel dan jawaban sekitar 18 sampai 20 piksel; pada mobile, sesuaikan agar tetap terbaca. Target sentuh publik minimal 48 piksel dengan jarak cukup. Seluruh fungsi penting dapat digunakan tanpa hover.

Breakpoint acuan: mobile di bawah 768 piksel, tablet 768 sampai 1279 piksel, desktop mulai 1280 piksel. Tidak mengunci resolusi 1920 kali 1080. Hindari scroll horizontal pada lebar 320 piksel. Sidebar admin menjadi navigasi yang dapat dibuka dan ditutup pada mobile; formulir tetap satu kolom atau tersusun ulang secara wajar.

Gunakan elemen button dan input yang benar, label field, focus ring, aria-expanded pada accordion, serta keyboard untuk membuka atau menutup pertanyaan. Pengurutan admin menyediakan alternatif tombol Naik dan Turun dalam keadaan daftar lengkap agar tidak bergantung hanya pada drag. Animasi singkat dan ringan; hormati prefers-reduced-motion.

## 11 Keamanan dan keadaan gagal

Rich text menggunakan allowlist elemen paragraf, strong atau b, em atau i, ul, ol, li, br, dan a. Buang script, event handler, style arbitrer, iframe, embed, img, serta atribut berbahaya. Tautan hanya memakai protokol yang diizinkan, seperti https, http, dan tel; tolak javascript dan data. Untuk tab baru gunakan rel yang aman. Sanitasi dilakukan di server menggunakan pustaka yang layak; jangan mengandalkan regex atau filter editor saja.

FAQ nonaktif tidak disertakan dalam payload publik, HTML tersembunyi, hasil pencarian, maupun halaman detail. Admin tidak boleh mengubah field di luar yang divalidasi. Mutasi status, urutan, profil, dan penghapusan tetap dilindungi middleware dan CSRF meskipun dipanggil melalui JavaScript.

Saat tidak ada FAQ aktif, tampilkan Informasi belum tersedia. Silakan hubungi petugas. Jangan memperlihatkan draft. Jika server tidak dapat diakses, browser dapat menampilkan kegagalan koneksi; aplikasi tidak menjanjikan offline penuh. Tidak diperlukan service worker atau salinan konten lokal pada versi pertama.

Saat session admin habis, arahkan ke login atau tampilkan pesan sesi berakhir untuk request JavaScript. Hindari pesan sukses pada respons gagal. Jika record sudah dihapus dari tab lain, tampilkan pemberitahuan dan segarkan daftar secara terkendali. Jangan mengekspos exception, password, atau konfigurasi database kepada pengguna.

## 12 Kebutuhan operasional aplikasi

CSS, JavaScript, font, icon, editor, dan logo tersedia sebagai aset lokal atau hasil build. Tidak bergantung pada CDN, Google Fonts, atau API eksternal untuk fungsi utama. Aplikasi dapat diterapkan di jaringan lokal rumah sakit maupun hosting online selama browser dapat menjangkau server. Aset lokal tidak berarti aplikasi tetap dapat dipakai ketika server atau jaringan ke server terputus.

Gunakan Vite untuk build produksi, environment yang sesuai, dan APP_DEBUG false pada produksi. Web server melayani direktori public. Tidak ada kredensial yang di-commit. File .env.example hanya memuat nama variabel serta contoh tanpa rahasia. Pemilihan hosting, perangkat, sertifikat, dan konfigurasi kiosk dilakukan pada tahap terpisah ketika diminta.

Acuan versi dan kebutuhan server: dokumentasi resmi Laravel di https://laravel.com/framework/docs/deployment. Versi aktual proyek tetap diperiksa sebelum implementasi.

## 13 Kriteria penerimaan

1. Pengunjung membuka daftar FAQ tanpa login dan hanya menerima data aktif, dengan urutan stabil.
2. Pencarian pertanyaan dan jawaban singkat tidak membedakan huruf besar atau kecil; hasil kosong memiliki tindakan hapus pencarian.
3. Accordion dapat dibuka dengan sentuhan dan keyboard; paling banyak satu terbuka.
4. Lihat Selengkapnya hanya muncul jika jawaban lengkap benar-benar berisi konten.
5. Detail nonaktif, tidak ditemukan, atau tanpa jawaban lengkap menghasilkan 404 yang ramah.
6. Disclaimer tampil persis pada daftar dan detail; nomor kontak tidak dibuat berdasarkan dugaan.
7. Setelah 60 detik tanpa interaksi, daftar kembali bersih dan detail kembali ke daftar; interaksi valid memperbarui timer.
8. Timer publik tidak mengganggu login atau pengeditan admin.
9. Semua halaman dan endpoint mutasi admin memerlukan autentikasi; logout benar-benar mengakhiri akses.
10. Login gagal memiliki pesan umum dan pembatasan percobaan yang bekerja.
11. Dashboard menampilkan jumlah dari database dan keadaan kosong yang benar.
12. Tambah dan edit memvalidasi field, mempertahankan input yang salah, serta memberikan hasil simpan yang jelas.
13. Rich text dapat memuat format yang diizinkan; payload script, gambar, embed, dan URL berbahaya ditolak atau dibuang.
14. Status nonaktif mencegah tampilan publik, termasuk akses langsung; pratinjau admin tetap tersedia.
15. Slug unik dibuat otomatis dan tetap stabil setelah pertanyaan diedit.
16. Pengurutan hanya tersedia pada daftar lengkap; urutan persisten setelah reload; input ID tidak valid ditolak.
17. Kegagalan penyimpanan urutan tidak meninggalkan tampilan sukses atau urutan database parsial.
18. Hapus memerlukan konfirmasi dan benar-benar menghapus record; batal tidak mengubah data.
19. Profil memvalidasi nama, email unik, dan password; perubahan sensitif memeriksa password saat ini.
20. Seeder tidak membuat duplikat, menimpa jawaban admin, atau mereset password akun yang telah ada.
21. Halaman dapat digunakan pada mobile, desktop, dan layar sentuh tanpa scroll horizontal atau ketergantungan hover.
22. Fungsi utama berjalan tanpa resource internet eksternal ketika server dapat diakses melalui jaringan lokal.

Pengujian dipusatkan pada perilaku yang berisiko: autentikasi, validasi, penyaringan aktif, sanitasi, slug, pengurutan transaksional, dan penghapusan. Lakukan pemeriksaan antarmuka, responsive, keyboard, serta idle reset secara manual atau melalui browser test yang sesuai. Laporkan apa yang benar-benar dijalankan; jangan mengklaim pengujian perangkat kiosk fisik tanpa perangkat tersebut.

## 14 Peta tahap pengembangan

Urutan berikut merupakan usulan kerja, bukan izin untuk mengeksekusi. Pemilik proyek dapat meminta tahap tertentu atau mengubah pembagiannya. Jika tahap yang diminta memiliki prasyarat yang belum tersedia, jelaskan prasyarat tersebut sebelum mengerjakan bagian yang bergantung padanya.

| Tahap | Lingkup yang diusulkan | Hasil untuk ditinjau |
| --- | --- | --- |
| 1 | Pemeriksaan proyek dan environment | Kondisi aktual, dependensi, rencana perubahan |
| 2 | Database | Migration, model dasar, seeder sesuai perintah |
| 3 | Autentikasi dan kerangka admin | Login, logout, middleware, layout |
| 4 | Pengelolaan FAQ | Validasi, CRUD, status, sanitasi, pratinjau |
| 5 | Pengurutan dan dashboard | Urutan persisten, ringkasan data |
| 6 | Halaman publik | Pencarian, accordion, detail, disclaimer |
| 7 | Profil dan penyempurnaan tampilan | Profil, password, responsive, aksesibilitas |
| 8 | Reset publik dan verifikasi | Timer 60 detik, pengujian fitur terkait |
| 9 | Persiapan penerapan | Build, konfigurasi, dokumentasi sesuai arahan |

Jika pemilik proyek hanya meminta migration dan seeder, jangan sekaligus membuat autentikasi, controller, atau halaman. Jika model juga diperlukan, nyatakan alasan dan pastikan lingkupnya sesuai perintah. Jangan menjalankan migration terhadap database yang belum ditetapkan sebagai target. Jangan menjalankan migrate:fresh, menghapus data, atau mengganti environment tanpa instruksi yang jelas.

## 15 Instruksi wajib untuk AI coder

Bagian ini berlaku sejak pertama kali dokumen diterima. Pemilik proyek menginginkan pengerjaan yang dapat dipahami dan ditinjau satu tahap demi satu tahap.

### 15.1 Saat pertama menerima PRD

Baca seluruh PRD, pahami keputusan yang telah disepakati, dan simpan konteksnya sebelum implementasi. Menerima PRD bukan instruksi untuk mulai coding. Jangan membuat migration, seeder, model, controller, route, halaman, memasang package, menjalankan migration, atau melakukan deployment hanya karena PRD sudah lengkap.

Jika AI memiliki akses workspace, simpan PRD lengkap sebagai docs/PRD.md dan aturan pengerjaan serta ringkasan keputusan sebagai docs/PROJECT_CONTEXT.md. Penyimpanan dua dokumen konteks ini diizinkan pada tahap penerimaan; jangan mengubah file aplikasi. Jangan menimpa file konteks yang berbeda tanpa memeriksa isinya. Jika AI hanya memiliki chat, akui keterbatasannya dan minta pemilik proyek menyimpan atau melampirkan PRD ketika sesi baru dimulai; jangan mengklaim memiliki memori permanen.

Ringkasan keputusan harus mencakup: FAQ edukasi hemodialisis untuk RSUD Dr. M. Yunus Bengkulu; dua tabel users dan faqs; satu admin; tanpa kategori dan gambar jawaban; jawaban singkat wajib dan lengkap opsional; rich text terbatas; status aktif atau nonaktif; urutan melalui drag-and-drop; hapus permanen dengan konfirmasi; search publik; detail memakai slug stabil; warna hijau hangat; disclaimer wajib; aset lokal; idle publik 60 detik; serta pengerjaan hanya atas perintah pemilik proyek.

Respons pertama cukup menyatakan bahwa PRD telah dipahami dan konteks sudah disimpan jika benar-benar berhasil, merangkum keputusan utama, lalu menyarankan tahap pertama. Setelah itu tunggu perintah. Jangan memulai tahap pertama sendiri.

### 15.2 Saat suatu tahap diminta

Kerjakan hanya tahap yang secara jelas diminta. Sebelum mengubah kode, baca PRD, konteks proyek, dan catatan progres terbaru. Periksa keadaan proyek yang relevan dengan tahap tersebut. Pertahankan pekerjaan yang sudah ada dan jangan mengulang setup dari nol tanpa alasan.

Jelaskan singkat tujuan serta hasil tahap yang akan dibuat, kemudian kerjakan lingkup yang diizinkan. Keputusan kecil yang sesuai PRD boleh ditangani dalam tahap tersebut. Jika keputusan mengubah scope, database, teknologi utama, atau perilaku yang sudah disepakati, sampaikan perubahan dan tunggu keputusan pemilik proyek sebelum bagian yang bergantung padanya.

### 15.3 Setelah suatu tahap selesai

Laporkan hasil secara ringkas: apa yang dibuat atau diubah, file yang relevan, pemeriksaan yang benar-benar dijalankan dan hasilnya, serta kendala yang masih ada. Perbarui docs/PROGRESS.md dengan tahap terakhir, status selesai atau belum selesai, keputusan baru, dan usulan langkah berikutnya. Jangan menyimpan password, token, atau isi .env rahasia dalam catatan progres.

Sampaikan satu tahap berikutnya yang direkomendasikan beserta alasan singkat, kemudian tanyakan apakah boleh dilanjutkan. Berhenti dan tunggu jawaban pemilik proyek. Jawaban oke atau lanjut hanya mengizinkan tahap berikutnya yang baru saja disebutkan, bukan seluruh sisa proyek. Jika tahap masih memiliki kendala penting, jelaskan dan usulkan penyelesaiannya terlebih dahulu.

### 15.4 Saat melanjutkan sesi lain

Baca docs/PRD.md, docs/PROJECT_CONTEXT.md, dan docs/PROGRESS.md sebelum bekerja. Gunakan dokumen tersebut serta kondisi aktual kode sebagai acuan; jangan bergantung hanya pada ringkasan percakapan. Perubahan eksplisit terbaru dari pemilik proyek mengungguli keputusan lama dan harus dicatat. Jika hasil suatu tahap belum diverifikasi, tandai keadaan tersebut dengan jujur.

### 15.5 Perintah awal yang menyertai PRD

Pelajari dan simpan PRD ini terlebih dahulu tanpa memulai implementasi. Ringkas keputusan utama, sarankan tahap pertama, lalu tunggu perintah saya. Kerjakan hanya tahap yang saya minta. Setelah selesai, laporkan hasil, perbarui catatan progres, dan sarankan tahap berikutnya. Lanjutkan hanya setelah saya menyetujuinya. Jangan mengerjakan beberapa tahap sekaligus.
