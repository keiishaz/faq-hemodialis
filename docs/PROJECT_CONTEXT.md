# Konteks proyek FAQ Hemodialisis

- Produk publik adalah FAQ Hemodialisis RSUD Dr. M. Yunus Bengkulu untuk edukasi umum pasien dan keluarga.
- Teknologi proyek adalah Laravel 13, PHP 8.3, Blade, Tailwind CSS, dan Vite. Aplikasi lokal diarahkan ke MySQL `faq_hemodialis` dengan utf8mb4. PHPUnit memakai SQLite sementara hanya untuk tes.
- Tabel domain adalah `users` untuk satu admin dan `faqs` untuk pertanyaan. Tidak ada kategori, gambar jawaban, atau akun pasien.
- FAQ memiliki jawaban singkat wajib, jawaban lengkap opsional, status aktif atau nonaktif, slug stabil, dan urutan yang dapat diubah admin.
- Jawaban lengkap menggunakan rich text terbatas dan harus disanitasi di server sebelum disimpan. Pertanyaan serta jawaban singkat tetap berupa teks yang di-escape.
- Seeder pertanyaan awal hanya memakai sembilan topik PRD. Tanpa jawaban resmi, semua record awal berisi `Jawaban belum tersedia.`, tidak mempunyai jawaban lengkap, dan nonaktif.
- Atas permintaan terbaru pemilik proyek, `AdminSeeder` berisi kredensial awal tetap dalam source code dan membuat satu akun admin. Seeder tidak mereset akun yang sudah ada saat dijalankan ulang.
- Login admin memakai session Laravel, email yang dipangkas dan diubah ke huruf kecil, serta batas lima kegagalan per 60 detik untuk kombinasi email dan IP. Logout adalah POST dan mengakhiri session.
- Profil admin menyediakan pembaruan nama dan email serta formulir password terpisah. Perubahan email memerlukan password saat ini; perubahan password meregenerasi session aktif dan merotasi remember token bila digunakan.
- Halaman publik memakai pencarian frontend, accordion satu terbuka, detail opsional, dan disclaimer persis sesuai PRD. Setelah 60 detik tanpa interaksi, daftar kembali ke keadaan awal dan detail kembali ke daftar. Timer hanya aktif pada layout publik.
- Arah visual terbaru mengikuti `UI_Reference_FAQ_Hemodialisis_RSUD_M_Yunus.pdf` untuk 12 keadaan publik dan admin. Palet biru dan sian pada referensi ini menggantikan palet hijau pada rancangan lama, tanpa mengubah fungsi, route, atau konten FAQ.
- Logo resmi yang diberikan pemilik proyek disalin utuh ke `public/images/rsud-m-yunus-logo.png` dan dipakai pada layar publik serta admin. Rasio dan piksel sumbernya dipertahankan. Tidak ada gambar jawaban.
- Login admin memakai foto gedung RSUD dari pemilik proyek di panel kiri. Ikon admin memakai SVG Tabler resmi yang tersimpan lokal pada `resources/icons`, dengan lisensi MIT disertakan; paket runtime baru tidak ditambahkan.
- Pengerjaan berlangsung satu tahap per persetujuan pemilik proyek. Lihat `PROGRESS.md` untuk status aktual.
