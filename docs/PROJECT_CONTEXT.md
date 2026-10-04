# Konteks proyek FAQ Hemodialisis

- Produk publik adalah FAQ Hemodialisis RSUD Dr. M. Yunus Bengkulu untuk edukasi umum pasien dan keluarga.
- Teknologi proyek adalah Laravel 13, PHP 8.3, Blade, Tailwind CSS, dan Vite. Aplikasi lokal diarahkan ke MySQL `faq_hemodialis` dengan utf8mb4. PHPUnit memakai SQLite sementara hanya untuk tes.
- Tabel domain adalah `users` untuk satu admin dan `faqs` untuk pertanyaan. Tidak ada kategori, gambar jawaban, atau akun pasien.
- FAQ memiliki jawaban singkat wajib, jawaban lengkap opsional, status aktif atau nonaktif, slug stabil, dan urutan yang dapat diubah admin.
- Jawaban lengkap menggunakan rich text terbatas dan harus disanitasi di server sebelum disimpan. Pertanyaan serta jawaban singkat tetap berupa teks yang di-escape.
- Seeder pertanyaan awal hanya memakai sembilan topik PRD. Tanpa jawaban resmi, semua record awal berisi `Jawaban belum tersedia.`, tidak mempunyai jawaban lengkap, dan nonaktif.
- Atas permintaan terbaru pemilik proyek, `AdminSeeder` berisi kredensial awal tetap dalam source code dan membuat satu akun admin. Seeder tidak mereset akun yang sudah ada saat dijalankan ulang.
- Login admin memakai session Laravel, email yang dipangkas dan diubah ke huruf kecil, serta batas lima kegagalan per 60 detik untuk kombinasi email dan IP. Logout adalah POST dan mengakhiri session.
- Halaman publik memakai pencarian frontend, accordion satu terbuka, detail opsional, dan disclaimer persis sesuai PRD. Reset setelah 60 detik tanpa interaksi masih menunggu Tahap 8.
- Tampilan publik mengikuti mockup yang telah ditinjau, dengan hijau `#236B5D`, sage `#DDEDE7`, latar `#F8F7F3`, putih, teks `#26332F`, dan aksen hangat terbatas `#D97757`.
- Aset utama tersedia secara lokal. Nomor kontak dan logo resmi hanya dipakai bila diberikan.
- Pengerjaan berlangsung satu tahap per persetujuan pemilik proyek. Lihat `PROGRESS.md` untuk status aktual.
