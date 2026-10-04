# Progres pengembangan

## Tahap 2: database

Status: selesai untuk penulisan kode pada 4 Oktober 2026. Migration belum dijalankan pada database aplikasi.

- Migration bawaan `users` disesuaikan untuk nama 100 karakter dan tanpa kolom verifikasi email atau tabel reset password yang belum dipakai.
- Migration `faqs` ditambahkan sesuai kolom, default, unique slug, dan index gabungan pada PRD.
- Model `Faq` memiliki cast status dan urutan serta scope aktif dan terurut.
- `FaqSeeder` menyiapkan sembilan pertanyaan PRD secara idempotent dengan jawaban placeholder dan status nonaktif. Seeder bawaan tidak lagi membuat pengguna uji.
- Tidak ada seeder admin karena kredensial awal belum diberikan. Tidak ada jawaban medis yang ditulis.
- Pengujian migration, constraint slug, default, scope, dan seeder menggunakan database SQLite sementara dari konfigurasi PHPUnit. Seluruh 5 tes dan 17 assertion lulus; pemeriksaan format Pint lulus.

Koreksi konfigurasi: `.env` dan contoh konfigurasi kini memakai MySQL lokal dengan database `faq_hemodialis`, sesuai database yang ditemukan di Laragon. Database itu kosong saat diperiksa. SQLite yang disebut sebelumnya adalah koneksi bawaan Laravel dan mesin tes PHPUnit, bukan target aplikasi. Migration dan seeder belum dijalankan pada MySQL.

Tahap berikutnya yang diusulkan: Tahap 3, autentikasi dan kerangka admin. Kredensial awal admin perlu disepakati sebelum akun admin dibuat.
