# Progres pengembangan

## Tambahan setelah Tahap 4: seeder admin

Status: selesai pada 4 Oktober 2026 atas permintaan pemilik proyek. Ini adalah tambahan khusus untuk akun admin, bukan pelaksanaan Tahap 5.

- `AdminSeeder` baru membuat satu record pada tabel `users` dengan email dan password awal tetap di source code sesuai instruksi terbaru pemilik proyek. Password disimpan sebagai hash oleh Laravel.
- `DatabaseSeeder` memanggil `AdminSeeder` lalu `FaqSeeder`. Menjalankan seeder ulang tidak mengganti nama, email, atau password akun yang sudah ada dan tidak menambah admin kedua.
- `php artisan db:seed --class=AdminSeeder` telah dijalankan pada MySQL `faq_hemodialis`. Pemeriksaan baca saja mengonfirmasi satu akun admin. Seeder FAQ tidak dijalankan pada MySQL dalam tambahan ini.
- Tes seeder memeriksa hash password, satu akun, perilaku saat diulang, dan integrasi `DatabaseSeeder`. Kredensial lengkap tidak dicatat di dokumen progres.

Tahap berikutnya yang diusulkan tetap Tahap 5: pengurutan persisten dan ringkasan dashboard. Pelaksanaan menunggu perintah pemilik proyek.

## Tahap 4: pengelolaan FAQ

Status: selesai untuk kode pada 4 Oktober 2026. Penggunaan lewat login admin di MySQL belum dapat diperiksa langsung karena tabel `users` masih kosong; tes fitur menggunakan pengguna sementara pada database tes.

- Daftar FAQ admin kini memiliki pencarian pertanyaan, filter Semua/Aktif/Nonaktif, badge status, waktu pembaruan, dan tindakan Edit, Pratinjau, Aktifkan/Nonaktifkan, serta Hapus Permanen dengan dialog konfirmasi.
- Form tambah dan edit memvalidasi pertanyaan, jawaban singkat, jawaban lengkap, serta status. Input yang gagal tetap tampil; perubahan yang belum disimpan meminta konfirmasi saat Batal atau keluar halaman. Simpan menampilkan keadaan proses.
- Editor jawaban lengkap mendukung paragraf, tebal, miring, daftar poin, daftar nomor, dan tautan. Sanitasi server menggunakan `symfony/html-sanitizer` versi 7.4 dengan elemen dan skema tautan terbatas. Jawaban yang kosong setelah sanitasi menjadi NULL. Pertanyaan dan jawaban singkat di-escape saat tampil.
- Slug dibuat unik saat FAQ baru disimpan, dengan fallback, dan tidak berubah saat diedit. FAQ baru ditempatkan di akhir urutan; perubahan status tidak mengubah urutan. Pratinjau admin dapat membuka FAQ nonaktif. Route mutasi dilindungi autentikasi dan CSRF.
- FAQ yang telah hilang dari tab lain mengarahkan admin ke daftar dengan pesan terkendali. Hapus permanen memakai DELETE. Pengurutan drag dan ringkasan dashboard tetap lingkup Tahap 5.
- MySQL `faq_hemodialis` telah dimigrasi pemilik proyek dan skemanya terverifikasi. Migration tidak dijalankan oleh AI pada MySQL. Seeder admin belum dibuat dan tabel `users` masih kosong.
- Pemeriksaan: 16 tes dan 132 assertion lulus, Pint lulus, build Vite lulus, Composer valid dan tidak melaporkan advisory, route admin terdaftar. Belum ada uji perangkat kiosk fisik atau inspeksi visual admin yang masuk ke MySQL.

Tahap berikutnya yang diusulkan: Tahap 5, pengurutan persisten dan dashboard. Alasannya, data FAQ serta tindakan admin kini tersedia sebagai dasar untuk kedua fitur tersebut. Pelaksanaan menunggu perintah pemilik proyek.

### Audit desain Tahap 4

Design read: panel pengelolaan FAQ untuk satu admin rumah sakit, dengan bahasa visual hangat dan tenang dari PRD serta kontrol administratif yang jelas.

- Design variance 3: tata letak stabil untuk tugas pengelolaan data.
- Motion intensity 2: hanya umpan balik fokus, tombol, dan dialog.
- Visual density 4: informasi tiap FAQ cukup lengkap tanpa tabel padat.
- Em-dash/en-dash audit: Pass, nol U+2014 dan U+2013 pada berkas UI Tahap 4.
- Section-Layout-Repetition: Pass, halaman daftar memakai pembuka, filter, lalu daftar kartu fungsional; form memakai satu kolom field dan toolbar; pratinjau memakai artikel jawaban.
- Hero discipline: Pass, panel admin tidak memakai hero pemasaran; judul daftar satu baris pada desktop, pengantar 14 kata, dan Tambah FAQ terlihat pada pembuka. Form dan pratinjau memakai judul halaman singkat.

Pre-Flight Check tasteskill Section 14, setiap kotak:

1. Pass, brief inference: panel FAQ rumah sakit untuk admin mengikuti kebutuhan pengelolaan yang jelas.
2. Pass, dial values: 3/2/4 disebutkan dengan alasan di atas.
3. Pass, design system: tema PRD dibangun pada Tailwind dan Blade yang sudah dipakai proyek.
4. Pass, redesign mode: kerangka admin Tahap 3 dipertahankan dan dinavigasi ulang hanya untuk FAQ.
5. Pass, karakter dash: tidak ada em-dash atau en-dash dalam berkas antarmuka baru.
6. Pass, page theme lock: semua layar Tahap 4 memakai tema terang.
7. Pass, color consistency: hijau rumah sakit tetap aksen utama; merah dibatasi untuk galat dan hapus.
8. Pass, shape consistency: bidang utama radius 16 piksel, kontrol radius 12 piksel.
9. Pass, button contrast: teks putih pada hijau utama terbaca; tombol destruktif memakai merah gelap.
10. Pass, CTA wrap: label Tambah FAQ, Simpan FAQ, dan Hapus Permanen tidak dirancang membungkus pada desktop.
11. Pass, form contrast: input berbatas gelap, label jelas, fokus sage, dan galat merah gelap.
12. Pass, serif discipline: tidak ada font serif.
13. Pass, premium palette: aplikasi publik rumah sakit memakai palet PRD, bukan palet produk premium.
14. Pass, italic clearance: tombol miring hanya berupa huruf I dengan ruang cukup; tidak ada judul miring.
15. Pass, hero viewport: tidak ada hero pemasaran; tindakan utama ditempatkan di pembuka halaman.
16. Pass, hero top padding: pembuka admin memakai jarak atas sedang, tanpa ruang kosong setinggi layar.
17. Pass, hero stack: pembuka daftar hanya berisi eyebrow, judul, pengantar, dan tindakan utama.
18. Pass, eyebrow count: satu eyebrow pada daftar dan satu pada pratinjau, sesuai konteks halaman terpisah.
19. Pass, split-header ban: judul dan pengantar tersusun vertikal.
20. Pass, zigzag cap: tidak ada pola gambar dan teks zigzag.
21. Pass, duplicate CTA: Tambah, Edit, Pratinjau, dan Hapus memiliki tujuan berbeda.
22. Pass, logo wall: tidak ada deretan logo.
23. Pass, bento diversity: tidak ada bento; daftar kartu dipakai sesuai PRD admin.
24. Pass, trusted-by wall: tidak ada klaim atau logo pihak lain.
25. Pass, copy audit: teks kontrol berbahasa Indonesia, deskriptif, dan tidak mengklaim konten medis.
26. Pass, motion motivated: transisi warna memberi umpan balik interaksi.
27. Pass, marquee: tidak ada marquee.
28. Pass, navigation line: header desktop tetap satu baris dan 72 piksel.
29. Pass, section layout repetition: pembuka, filter, kartu, formulir, dan artikel pratinjau memiliki fungsi berbeda.
30. Pass, bento rhythm: tidak ada bento atau sel kosong.
31. Pass, long lists: daftar FAQ memakai kartu administratif sesuai PRD, bukan daftar bergaris rapat.
32. Pass, real images: gambar jawaban dilarang PRD dan tidak ada gambar dekoratif yang diperlukan.
33. Pass, image overlays: tidak ada gambar atau label di atas gambar.
34. Pass, photo credits: tidak ada foto dekoratif.
35. Pass, version footer: tidak ada label versi.
36. Pass, micro-meta: tidak ada kalimat dekoratif di bawah eyebrow.
37. Pass, hero strip: tidak ada strip slogan.
38. Pass, floating heading subtext: tidak ada teks penjelas mengambang.
39. Pass, scoring bars: tidak ada batang penilaian.
40. Pass, locale strips: tidak ada strip kota, cuaca, atau jam.
41. Pass, scroll cues: tidak ada petunjuk gulir dekoratif.
42. Pass, hero version: tidak ada label versi di pembuka.
43. Pass, section numbering eyebrow: tidak ada penomoran dekoratif.
44. Pass, decorative dots: tidak ada titik dekoratif.
45. Pass, repeated row borders: daftar kartu memakai batas per kartu, bukan garis atas dan bawah berulang.
46. Pass, content density: setiap kartu menampilkan informasi kerja yang relevan tanpa tabel padat.
47. Pass, quotes: tidak ada kutipan.
48. Pass, motion claimed: intensitas 2 sesuai transisi warna ringan yang digunakan.
49. Pass, GSAP patterns: tidak ada animasi GSAP atau gulir kompleks.
50. Pass, scroll listener: tidak ada pendengar acara gulir.
51. Pass, reduced motion: CSS global menekan durasi animasi dan transisi saat diminta.
52. Pass, dark mode: tema tunggal terang sesuai PRD dan theme lock; mode gelap tidak diminta.
53. Pass, mobile collapse: daftar tindakan membungkus, form satu kolom, dan navigasi mobile tersedia.
54. Pass, viewport stability: layout memakai `dvh`, tanpa tinggi layar tetap.
55. Pass, useEffect cleanup: Blade dan JavaScript ringan tidak memakai React atau `useEffect`.
56. Pass, empty/loading/error: daftar kosong, tombol simpan memproses, validasi field, dan pesan error tersedia.
57. Pass, cards omitted: kartu dipakai hanya untuk record FAQ sesuai kebutuhan administratif PRD.
58. Pass, icons: kontrol memakai label teks, tanpa ikon campuran atau SVG buatan.
59. Pass, motion client leaf: tidak ada komponen animasi React.
60. Pass, AI tells: tidak ada tiga kartu promosi setara, warna ungu, atau konten pemasaran.
61. Pass, Core Web Vitals plausibility: build lokal kecil dan tidak memuat font atau gambar jaringan; metrik lapangan belum diukur.
62. Pass, one design system: hanya Tailwind lokal dan token PRD yang digunakan.

## Tahap 3: autentikasi dan kerangka admin

Status: selesai untuk kode pada 4 Oktober 2026. Uji login langsung terhadap MySQL menunggu migration dan akun admin yang akan disiapkan pemilik proyek.

- Route login dan dashboard admin ditambahkan dengan middleware guest dan auth. Logout hanya menggunakan POST.
- Login menormalisasi email, memberi kesalahan kredensial yang umum, serta membatasi lima kegagalan per 60 detik per email dan IP.
- Session diregenerasi setelah login, lalu diakhiri dan token CSRF diregenerasi saat logout. Respons area admin memakai `Cache-Control: no-store`.
- Layout admin dasar dan formulir login memakai aset Vite lokal. Formulir memberi umpan balik saat dikirim dan menampilkan kesalahan dekat field. Pemuatan font jarak jauh bawaan dihapus agar build tidak bergantung pada jaringan luar.
- Dashboard pada tahap ini hanya kerangka akses; ringkasan data, pengelolaan FAQ, dan profil tetap pada tahap selanjutnya.
- Tes HTTP mencakup pembatasan akses tamu, login, throttle, logout, dan redirect. Seluruh 9 tes dan 52 assertion lulus; pemeriksaan Pint dan build Vite lulus. Halaman login diperiksa di browser pada desktop dan lebar 320 piksel tanpa scroll horizontal, dengan driver session file sementara dan tanpa perubahan konfigurasi aplikasi.

Tahap berikutnya yang diusulkan: Tahap 4, pengelolaan FAQ. Sebelum penggunaan langsung, pemilik proyek menjalankan migration pada MySQL `faq_hemodialis` dan menetapkan kredensial awal admin melalui cara yang disepakati.

### Audit desain Tahap 3

- Em-dash dan en-dash: Pass. Pemeriksaan berkas antarmuka menemukan nol U+2014 dan U+2013.
- Section-Layout-Repetition: Pass. Login memakai header teks dan formulir tunggal; area admin memakai sidebar, header tindakan, dan ruang konten; tidak ada grid kartu berulang.
- Hero discipline: Pass. Judul login satu baris pada desktop dan ponsel 320 piksel, pengantar lima kata, dan tombol Masuk terlihat pada pemeriksaan desktop serta ponsel 320 x 640.

Pre-Flight Check tasteskill Section 14, satu keputusan untuk setiap kotak:

1. Pass, brief inference: layar admin untuk satu pengelola mengikuti bahasa visual rumah sakit yang tenang.
2. Pass, dial values: variance 3, motion 2, density 4 mengikuti keputusan desain yang telah disetujui.
3. Pass, design system: tema khusus PRD dibangun dengan token Tailwind lokal.
4. Pass, redesign mode: area admin masih baru sehingga audit redesign tidak diperlukan.
5. Pass, karakter dash: tidak ada U+2014 atau U+2013 pada layar admin.
6. Pass, page theme lock: seluruh layar admin memakai tema terang.
7. Pass, color consistency: hijau PRD dipakai sebagai aksen utama.
8. Pass, shape consistency: bidang memakai sudut lunak 16 piksel dan kontrol 12 piksel secara konsisten.
9. Pass, button contrast: teks putih pada hijau mempunyai rasio sekitar 6,30:1.
10. Pass, CTA wrap: label Masuk dan Keluar tetap satu baris pada desktop.
11. Pass, form contrast: batas input terhadap putih sekitar 4,58:1; label, pesan galat, dan fokus terbaca.
12. Pass, serif discipline: tidak ada font serif.
13. Pass, premium palette: konteks rumah sakit memakai palet PRD, bukan palet premium konsumen.
14. Pass, italic clearance: tidak ada teks miring.
15. Pass, hero viewport: judul satu baris, pengantar singkat, dan tombol terlihat dalam viewport yang diuji.
16. Pass, hero top padding: jarak atas konten login kecil dan tidak memindahkan isi ke bawah layar.
17. Pass, hero stack: pembuka login hanya berisi judul dan satu kalimat.
18. Pass, eyebrow count: login tidak memakai eyebrow; dashboard memakai satu.
19. Pass, split-header ban: judul dan penjelasan berada dalam satu kolom.
20. Pass, zigzag cap: tidak ada pola gambar dan teks zigzag.
21. Pass, duplicate CTA: Masuk dan Keluar mempunyai maksud berbeda.
22. Pass, logo wall: tidak ada deretan logo.
23. Pass, bento diversity: tidak ada bento pada tahap ini.
24. Pass, trusted-by wall: tidak ada klaim logo pihak lain.
25. Pass, copy audit: teks antarmuka singkat dan tidak menyatakan fitur tahap lain sudah tersedia.
26. Pass, motion motivated: transisi warna hanya memberi umpan balik kontrol.
27. Pass, marquee: tidak ada marquee.
28. Pass, navigation line: header admin satu baris pada desktop dengan tinggi 72 piksel.
29. Pass, section layout repetition: login, navigasi samping, dan ruang konten memakai fungsi serta komposisi berbeda.
30. Pass, bento rhythm: tidak ada bento atau sel kosong.
31. Pass, long lists: belum ada daftar panjang pada tahap ini.
32. Pass, real images: logo resmi belum diberikan dan gambar tidak diperlukan untuk login.
33. Pass, image overlays: tidak ada gambar atau label di atasnya.
34. Pass, photo credits: tidak ada kredit foto dekoratif.
35. Pass, version footer: tidak ada label versi.
36. Pass, micro-meta: tidak ada kalimat dekoratif di bawah eyebrow.
37. Pass, hero strip: tidak ada strip slogan.
38. Pass, floating heading subtext: tidak ada teks mengambang di sudut judul.
39. Pass, scoring bars: tidak ada batang penilaian.
40. Pass, locale strips: tidak ada strip kota, waktu, atau cuaca.
41. Pass, scroll cues: tidak ada petunjuk gulir dekoratif.
42. Pass, hero version: tidak ada label versi pada pembuka.
43. Pass, section numbering eyebrow: tidak ada nomor dekoratif pada bagian.
44. Pass, decorative dots: tidak ada titik dekoratif.
45. Pass, repeated row borders: tidak ada daftar baris bergaris ganda.
46. Pass, content density: formulir hanya berisi dua field wajib dan satu tindakan.
47. Pass, quotes: tidak ada kutipan.
48. Pass, motion claimed: intensitas 2 sesuai transisi ringan yang benar-benar ada.
49. Pass, GSAP patterns: tidak ada animasi GSAP atau efek gulir kompleks.
50. Pass, scroll listener: tidak ada pendengar acara gulir.
51. Pass, reduced motion: aturan CSS menghilangkan durasi transisi dan animasi saat diminta.
52. Pass, dark mode: tema tunggal terang sesuai theme lock; mode gelap tidak diminta.
53. Pass, mobile collapse: formulir satu kolom dan halaman tidak melebar pada 320 piksel.
54. Pass, viewport stability: tinggi memakai `dvh`, bukan tinggi layar tetap.
55. Pass, useEffect cleanup: aplikasi Blade tidak memakai React atau `useEffect`.
56. Pass, empty/loading/error: form awal kosong, tombol memberi status proses, dan galat muncul dekat field.
57. Pass, cards omitted: hanya formulir dan satu bidang status dashboard, tanpa grid kartu.
58. Pass, icons: tidak ada ikon dekoratif atau SVG buatan.
59. Pass, motion client leaf: tidak ada komponen animasi React.
60. Pass, AI tells: tidak ada pola tiga kartu setara, warna ungu, atau konten pemasaran generik.
61. Pass, Core Web Vitals plausibility: aset lokal kecil dan tanpa font jaringan; angka performa nyata belum diklaim.
62. Pass, one design system: hanya token PRD dan Tailwind yang dipakai.

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
