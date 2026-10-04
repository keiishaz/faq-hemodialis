# Progres pengembangan

## Koreksi skala dan penyempurnaan FAQ publik

Status: selesai pada 5 Oktober 2026. Header, hero, pencarian, accordion, detail, dan keadaan 404 diperkecil untuk ponsel serta desktop biasa. Viewport minimal 1600 piksel lebar dan 900 piksel tinggi memakai ukuran kiosk yang lebih lapang. Footer bernuansa biru sangat muda memuat alamat Jl. Bhayangkara, Kota Bengkulu dan nomor (0736) 52004 dari [profil RS Kementerian Kesehatan](https://sirs.kemkes.go.id/fo/home/profile_rs/1771014); nilai `HOSPITAL_CONTACT` tetap dapat mengganti nomor yang tampil. Disclaimer asli tetap utuh.

- Dua lingkaran pada latar biru bergerak perlahan ke arah berlawanan dengan transformasi dan opasitas CSS. Keduanya berjalan dalam siklus 16 dan 20 detik sehingga geraknya tampak tetapi tidak mengganggu bacaan. Teks hero dan panel pencarian masuk sekali secara singkat; jawaban accordion muncul dengan transisi singkat. `prefers-reduced-motion` menonaktifkan semua animasi. Tidak ada loop JavaScript, dependensi, atau perubahan perilaku pencarian dan reset kiosk.
- Pertanyaan FAQ kini berada dalam satu panel dengan pemisah tipis, teks berbobot 600 tanpa perubahan ukuran, ikon tanya kecil di kiri, tombol plus berbentuk lingkaran di kanan, dan garis biru yang menandai jawaban terbuka. Hasil pencarian kosong menjadi baris ringkas pada desktop dan susunan vertikal pada ponsel; panel FAQ yang tidak memiliki baris terlihat disembunyikan. Footer menyusun identitas RS, kontak, dan disclaimer pada bidang biru muda yang tenang.
- Pemeriksaan browser pada 320 piksel, desktop biasa, 1920 x 800, dan kiosk 1920 x 1080 menunjukkan breakpoint besar hanya aktif pada viewport lebar sekaligus tinggi. Pada 320 piksel lebar dokumen 305 piksel untuk viewport 320 piksel; input pencarian 49 piksel dan tombol accordion minimal 76 piksel. Pada kiosk judul 64 piksel dan kontainer FAQ 1120 piksel; ukuran teks pertanyaan tetap 21 piksel. Detail, footer, hasil pencarian kosong, dan accordion terbuka diperiksa. Animasi lingkaran terkonfirmasi aktif pada CSS dengan durasi 16 detik.
- `npm run build`, 38 tes dengan 278 assertion sebelum penyempurnaan baris hasil kosong, lalu empat tes publik dengan 42 assertion setelahnya, `git diff --check`, dan audit karakter em-dash/en-dash lulus. Tidak ada perubahan pada rute, JavaScript, controller, model, validasi, database, atau data MySQL.
- Section-Layout-Repetition: Pass. Hero memperkenalkan topik, panel pencarian menjalankan tugas pencarian, panel accordion menampilkan FAQ sebagai daftar berpemisah, dan footer memuat identitas, kontak, serta disclaimer.
- Hero discipline: Pass. Judul satu baris pada desktop/kiosk dan paling banyak dua baris pada ponsel; pengantar enam kata dan pencarian terlihat pada viewport awal. Gerak teks hanya sekali saat halaman masuk.
- Pre-Flight Check Section 14: 62 butir audit bernomor pada bagian redesign di bawah tetap Pass setelah skala publik, footer, dan animasi ini diperiksa; butir hero, navigasi, gambar, gerak, konten, dan reduced motion telah dinilai ulang.

## Redesign visual setelah Tahap 9

Status: penyesuaian admin terakhir selesai pada 5 Oktober 2026. Redesign mengikuti prompt tasteskill dan PDF referensi terbaru untuk 12 keadaan publik serta admin, dengan pengecualian login dua sisi sesuai permintaan langsung pemilik proyek. Palet biru dan sian menggantikan palet hijau rancangan sebelumnya. Logo resmi PNG disalin utuh dan dipakai konsisten pada layout publik, login, serta layout admin.

- View publik, view admin, layout, dan CSS diperbarui untuk hierarki, spacing, responsivitas, fokus, keadaan accordion, hasil pencarian kosong, 404, status FAQ, serta dialog hapus. Koreksi admin terakhir mempertahankan login dua sisi dengan foto gedung di kiri, lalu mengecilkan header, sidebar, navigasi, judul, kartu metrik, dan jarak konten ke skala kerja yang lebih wajar. Ikon Tabler lokal tetap dipakai pada navigasi dan aksi, Keluar berwarna merah, dan urutan FAQ memakai pegangan seret berikon. Bagian Status pada formulir kini berada dalam alur normal dengan garis pemisah yang berjarak dari label, pilihan, dan tombol; teks bantuan yang tidak perlu disembunyikan dari tampilan tetapi tetap tersedia bagi pembaca layar. Motion dekoratif pelan dibatasi pada hero publik dan menghormati `prefers-reduced-motion`.
- Rute, nama rute, label navigasi utama, field formulir, ID dan hook yang ada, disclaimer, JavaScript, controller, model, validasi, migration, seeder, dan data MySQL tidak diubah. Sesuai instruksi terbaru untuk mengikuti PDF, judul daftar admin menjadi Kelola FAQ dan judul profil menjadi Profil; pintasan Edit pada tabel dashboard serta tautan kembali di atas formulir dihilangkan karena aksi Edit tetap tersedia di daftar FAQ dan formulir masih memiliki tombol Batal. Tes heading profil disesuaikan.
- Pemeriksaan browser mencakup publik dan login pada ukuran kiosk serta HP 320 piksel; hasil kosong, accordion, detail, dan 404 diperiksa. Enam halaman admin terautentikasi serta dialog hapus diperiksa melalui HTML preview sementara dari tes SQLite dalam memori dengan data sintetis dan jawaban placeholder. Setelah koreksi skala, login, dashboard, dan formulir tambah diperiksa lagi pada desktop serta HP 320 piksel; pemisah Status dan tombol diverifikasi tidak bersinggungan, ikon termuat, dan tidak ada luapan horizontal pada 320 piksel. Tes preview dan berkas HTML publik sementaranya dihapus setelah pemeriksaan sehingga MySQL tidak tersentuh.
- Setelah koreksi admin, `npm run build` tanpa peringatan aset, seluruh 38 tes dengan 278 assertion, dan `git diff --check` lulus.
- Audit em-dash/en-dash dan seluruh 62 butir tasteskill Section 14 dilaporkan Pass. Hash SHA-256 logo salinan sama dengan file resmi sumber. Foto gedung yang diberikan pemilik proyek dipakai pada login tanpa suntingan. Penyimpangan yang disengaja dari PDF: login dua sisi berfoto sesuai instruksi langsung, kolom password saat ini di profil tetap tersedia sesuai validasi aplikasi, dan jawaban medis contoh pada PDF tidak dimasukkan ke data.
- Database MySQL tetap berisi data lama. Saat pemeriksaan terdapat satu FAQ aktif dengan konten percobaan; konten medis perlu ditinjau pengelola sebelum aplikasi digunakan pasien.

Tahap redesign tidak menetapkan Step 5. Kelanjutan perlu dipilih pemilik proyek setelah meninjau layar admin dengan data dan kredensial miliknya.

### Audit akhir redesign

Design read: antarmuka FAQ rumah sakit untuk pasien, keluarga, pengunjung, dan pengelola, dengan bahasa visual tenang, terbaca, dan profesional yang mengikuti PDF referensi. `DESIGN_VARIANCE=3` karena layanan kesehatan membutuhkan komposisi stabil; `MOTION_INTENSITY=2` karena gerak hanya dekorasi lembut pada publik; `VISUAL_DENSITY=4` karena tugas admin memerlukan informasi ringkas tanpa sesak. Mode tasteskill: Overhaul visual dengan mekanisme aplikasi tetap.

- Em-dash dan en-dash: Pass. Tidak ditemukan U+2014 atau U+2013 pada view, CSS, dan JavaScript antarmuka.
- Section-Layout-Repetition: Pass. Publik memakai identitas header, hero, pencarian, daftar accordion, dan footer sesuai fungsi. Admin memakai login dua sisi, ringkasan dan tabel dashboard, tabel pengelolaan, panel editor, artikel pratinjau, dialog konfirmasi, dan dua panel formulir profil.
- Hero discipline: Pass. Judul publik satu baris di desktop dan maksimal dua baris pada HP 320 piksel, pengantar enam kata, serta pencarian muncul pada viewport awal. Layar admin tidak memakai hero pemasaran.
- Preservation: Pass. Perubahan URL/rute, nama rute, label navigasi utama, nama field form, ID/hook yang sudah ada, disclaimer, aturan bisnis, dan perilaku backend: tidak ada. Perbandingan atribut `name`, `id`, dan `data-*` pada view terhadap Git HEAD tidak menemukan atribut lama yang hilang. Judul Daftar FAQ menjadi Kelola FAQ, Profil admin menjadi Profil, pintasan Edit pada dashboard, dan tautan kembali di atas formulir dihapus untuk menyamai PDF; fungsi Edit tetap tersedia pada daftar FAQ dan Batal tetap ada di formulir.
- Database/backend: Pass. Tidak ada perubahan migration, tabel, kolom, relasi, model, controller, validasi, kontrak API, seeder, atau data MySQL untuk redesign. Perubahan `.env.example` dan `composer.json` yang sudah ada berasal dari Tahap 9, bukan redesign.
- Logo: Pass. SHA-256 salinan PNG sama dengan sumber resmi; seluruh oval, teks, dan pita terlihat dengan `object-contain` serta rasio asli. Foto gedung login memakai berkas yang diberikan pemilik proyek.
- Reference fidelity: Pass. Halaman PDF 1 sampai 4 dipenuhi oleh beranda, detail, hasil pencarian kosong, dan 404 publik. Halaman 6 sampai 12 dipenuhi oleh dashboard, daftar FAQ, tambah, edit, pratinjau nonaktif, dialog hapus, dan profil admin. Login memakai kembali komposisi dua sisi atas permintaan langsung, dengan foto gedung menggantikan bidang biru, sehingga sengaja berbeda dari halaman 5 PDF. Aksi daftar kini berikon seperti PDF dengan nama aksesibel; kolom password saat ini pada profil tetap ada karena validasi yang berjalan; konten medis contoh pada PDF tidak disalin ke data.

| Halaman PDF | Hasil | Kesesuaian dan penyesuaian |
| --- | --- | --- |
| 1. Beranda FAQ | Pass | Identitas, hero, pencarian, dan accordion mengikuti hierarki referensi. |
| 2. Detail FAQ | Pass | Artikel, tautan kembali, dan disclaimer tetap jelas. |
| 3. Hasil pencarian kosong | Pass | Pesan dan pemulihan pencarian terlihat. |
| 4. Konten tidak tersedia | Pass | Keadaan 404 memakai bahasa visual yang sama. |
| 5. Login admin | Pass | Komposisi dua sisi dan foto gedung di kiri adalah pengecualian yang diminta langsung pemilik proyek; ukuran header dan kartu diperkecil. |
| 6. Dashboard | Pass | Sidebar, topbar, tiga metrik nyata, dan tabel terbaru mengikuti referensi dengan skala yang lebih rapat; pintasan Edit di tabel dihapus. |
| 7. Kelola FAQ | Pass | Pencarian, tab, gagang urutan, tabel, status, dan aksi berikon mengikuti referensi. |
| 8. Tambah FAQ | Pass | Panel formulir, toolbar, status, dan aksi simpan mengikuti referensi; garis pemisah Status memiliki jarak yang jelas. |
| 9. Edit FAQ | Pass | Memakai struktur formulir yang sama dengan data dan validasi yang telah ada; pemisah Status juga diperbaiki. |
| 10. Pratinjau nonaktif | Pass | Banner status, artikel, disclaimer, dan Edit mengikuti susunan referensi. |
| 11. Konfirmasi hapus | Pass | Dialog menampilkan pertanyaan, peringatan, Batal, dan aksi merah sesuai referensi. |
| 12. Profil | Pass | Dua panel akun dan password mengikuti referensi; kolom password saat ini untuk perubahan email tetap tersedia sesuai validasi. |

- HCI/accessibility: Pass. Hierarki, affordance, status aktif/nonaktif, label form, fokus keyboard, konfirmasi hapus, target sentuh, kontras, dan responsivitas diperiksa. Tidak ada tindakan penting yang hanya dapat dilakukan melalui hover.
- Motion/performance: Pass. Dekorasi hero publik memakai transform CSS pelan, tanpa library animasi atau loop JavaScript; `prefers-reduced-motion` mematikannya. Build CSS sekitar 82 KB dan JavaScript sekitar 7 KB sebelum gzip, foto login sekitar 75 KB, serta ikon SVG lokal masing-masing di bawah 1 KB; metrik Web Vitals produksi belum diukur.
- Brand/design quality: Pass. Logo dan foto RSUD asli, bahasa Indonesia, komposisi layanan informasi, ikon garis yang konsisten, palet biru-sian PDF, radius konsisten, serta batas dekorasi menghindari templat medis generik dan tumpukan kartu tanpa fungsi.

Pre-Flight Check tasteskill Section 14, setiap kotak:

1. Pass: design read untuk layanan FAQ rumah sakit dinyatakan di atas.
2. Pass: tiga dial beserta alasan ditetapkan secara eksplisit.
3. Pass: Blade, Tailwind, dan CSS lokal dipakai sebagai satu fondasi proyek.
4. Pass: mode Overhaul visual disertai audit serta pembekuan mekanisme.
5. Pass: nol em-dash dan en-dash pada antarmuka.
6. Pass: tema terang tetap pada seluruh layar publik dan admin.
7. Pass: biru PDF adalah aksen utama; hijau status dan merah bahaya bermakna semantik.
8. Pass: panel, field, dan tombol memakai radius lembut yang konsisten.
9. Pass: teks putih pada tombol biru berkontras sekitar 5,84:1.
10. Pass: label CTA tidak membungkus pada desktop.
11. Pass: label, teks, border, dan fokus field memiliki kontras yang jelas.
12. Pass: tidak ada font serif.
13. Pass: larangan palet premium konsumen tidak relevan untuk rumah sakit dan tidak dipakai.
14. Pass: tidak ada judul display miring yang dapat terpotong.
15. Pass: judul publik paling banyak dua baris, pengantar enam kata, dan pencarian terlihat di awal.
16. Pass: jarak atas hero publik 48 piksel pada desktop biasa dan 76 piksel pada kiosk tinggi untuk menjaga pencarian tetap terlihat di viewport awal.
17. Pass: hero publik hanya berisi judul dan pengantar.
18. Pass: tidak ada eyebrow dekoratif berulang di atas judul section.
19. Pass: tidak ada pola judul besar kiri dengan penjelasan kecil di kanan.
20. Pass: tidak ada section gambar-teks zigzag.
21. Pass: tindakan yang sama tidak digandakan pada satu keadaan layar.
22. Pass: tidak ada logo wall.
23. Pass: tidak ada bento dekoratif.
24. Pass: tidak ada strip trusted-by atau logo palsu.
25. Pass: teks antarmuka diperiksa dan preview sintetis tidak mengarang jawaban medis.
26. Pass: gerak mendukung kedalaman visual hero tanpa menggerakkan isi medis.
27. Pass: tidak ada marquee.
28. Pass: topbar desktop setinggi 64 piksel; sidebar lebih ringkas dengan navigasi 14 piksel dan target sentuh 44 piksel.
29. Pass: setiap kelompok konten memakai bentuk yang sesuai tugasnya, seperti tabel atau formulir.
30. Pass: tidak ada sel bento kosong.
31. Pass: FAQ publik memakai accordion dan admin memakai tabel/daftar responsif.
32. Pass: gambar yang dipakai adalah logo resmi dan foto gedung dari pengguna; gambar jawaban tidak ditambahkan.
33. Pass: tidak ada label dekoratif yang menutupi gambar.
34. Pass: tidak ada kredit foto dekoratif.
35. Pass: tidak ada footer versi produk.
36. Pass: tidak ada kalimat meta kecil di bawah eyebrow.
37. Pass: tidak ada strip teks dekoratif di dasar hero.
38. Pass: tidak ada subteks melayang pada kanan judul section.
39. Pass: tidak ada bar skor atau progres dekoratif.
40. Pass: tidak ada strip lokasi, cuaca, atau waktu.
41. Pass: tidak ada petunjuk scroll dekoratif.
42. Pass: tidak ada label versi pada hero.
43. Pass: tidak ada eyebrow nomor section.
44. Pass: tidak ada titik dekoratif tanpa status.
45. Pass: baris tabel memakai pemisah bawah saja, bukan bingkai atas dan bawah berulang.
46. Pass: pratinjau sintetis hanya enam FAQ; tampilan nyata mengikuti data dan tugas pengelolaan.
47. Pass: tidak ada kutipan atau atribusi dekoratif.
48. Pass: intensitas gerak bernilai 2, sehingga animasi besar tidak diklaim.
49. Pass: tidak ada GSAP atau pola sticky/horizontal pan.
50. Pass: tidak ada scroll-driven animation; pendeteksi idle scroll yang sudah ada tetap untuk fungsi kiosk.
51. Pass: preferensi reduced motion mematikan dekorasi hero.
52. Pass: mode gelap tidak diperlukan karena tema terang dikunci.
53. Pass: sidebar admin berubah menjadi menu mobile dan tidak ada luapan horizontal pada 320 piksel.
54. Pass: layout memakai tinggi minimum viewport dinamis, bukan tinggi layar kaku.
55. Pass: tidak ada React `useEffect`; JavaScript lama mempertahankan pelepasan listener.
56. Pass: keadaan kosong, error validasi, status, dan simpan yang sudah ada tetap ditampilkan.
57. Pass: kartu dipakai hanya untuk pengelompokan metrik, form, daftar, dan artikel.
58. Pass: ikon SVG berasal dari paket resmi Tabler berlisensi MIT, disimpan lokal, dan tidak digambar ulang.
59. Pass: tidak ada komponen React atau animasi client-leaf yang perlu diisolasi.
60. Pass: tiga kartu metrik admin mewakili tiga hitungan nyata, bukan fitur pemasaran palsu.
61. Pass: foto 75 KB, ikon lokal kecil, dan animasi transform ringan membuat target Web Vitals masuk akal; pengukuran produksi masih perlu dilakukan.
62. Pass: satu sistem visual Tailwind lokal dipakai di seluruh aplikasi.

## Tahap 9: persiapan penerapan

Status: persiapan kode selesai pada 4 Oktober 2026. Aplikasi belum diterapkan ke server dan data MySQL tidak diubah.

- Skrip `composer setup` tidak lagi menjalankan migration otomatis. Skrip `post-create-project-cmd` tidak lagi membuat berkas SQLite atau menjalankan migration. Migration MySQL tetap dijalankan sendiri oleh pemilik proyek setelah target diperiksa.
- `.env.example` memakai nama aplikasi yang sesuai dan mencantumkan `HOSPITAL_CONTACT` sebagai variabel opsional tanpa nilai rahasia. `.env` yang sedang dipakai tidak diubah.
- Build produksi Vite berhasil dan menghasilkan manifest serta aset CSS dan JavaScript lokal di `public/build`. Direktori build diabaikan Git, sehingga proses penerapan harus membangun aset atau menyertakan hasil build tersebut. Berkas `public/hot` tidak ada.
- Pemeriksaan `composer validate --no-check-publish`, 38 tes dengan 278 assertion, daftar route, dan `git diff --check` lulus. Tidak ditemukan URL aset eksternal pada view aplikasi, JavaScript, CSS, atau kode aplikasi yang diperiksa. Pemeriksaan perangkat kiosk fisik belum dilakukan.
- Server tujuan perlu PHP 8.3 atau lebih baru beserta ekstensi Laravel, MySQL, web root `public`, dan izin tulis untuk `storage` serta `bootstrap/cache`. Konfigurasi server perlu `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` sesuai alamat nyata, `APP_KEY` yang disimpan aman, koneksi MySQL, dan aset hasil build. Jalankan `php artisan optimize` setelah konfigurasi produksi benar. Route `/up` dapat memeriksa aplikasi dapat boot, tetapi tidak membuktikan koneksi MySQL atau mutu konten.
- Sebelum aplikasi dipakai pasien, pengelola perlu meninjau seluruh FAQ aktif. Pemeriksaan baca saja menemukan sembilan FAQ, satu aktif, dan satu FAQ aktif tersebut masih berisi jawaban placeholder. Seeder admin masih memuat kredensial awal tetap dalam source code sesuai permintaan pemilik proyek; kredensial itu perlu diganti sebelum akses produksi. Jangan menjalankan seeder admin pada produksi dengan kredensial awal tersebut.
- Target hosting atau jaringan, sertifikat, perangkat kiosk, dan cara membawa artefak build belum ditetapkan. Tidak ada migration, seeder, perubahan `.env`, cache konfigurasi, atau deployment yang dijalankan pada tahap ini.

Langkah berikutnya yang diusulkan: tetapkan target penerapan dan cara membangun atau mengirim aset, lalu amankan kredensial admin serta tinjau konten FAQ aktif sebelum aplikasi digunakan. Pelaksanaan menunggu arahan pemilik proyek.

Audit desain Tahap 9: tidak ada perubahan UI. Audit em-dash dan en-dash pada berkas yang diubah: Pass, nol U+2014 dan U+2013. Section-Layout-Repetition dan hero discipline tetap seperti Tahap 8. Pre-Flight Check Section 14 tidak diulang karena halaman dan interaksinya tidak diubah.

## Tahap 8: reset publik dan verifikasi

Status: selesai untuk kode pada 4 Oktober 2026. Data MySQL tidak diubah pada tahap ini.

- Timer tunggal 60 detik dipasang hanya pada layout publik. Pointerdown, input, keydown, roda gulir, dan scroll pengguna memperbarui waktu terakhir interaksi. Hover dan gerakan pointer tanpa tindakan tidak memperbaruinya.
- Pada daftar, reset menghapus pencarian, menutup semua accordion dan dialog publik yang terbuka, melepas fokus kontrol, serta menggulir ke atas tanpa memuat ulang halaman. Gulir yang dihasilkan reset tidak mengaktifkan timer lagi. Daftar kosong juga diperlakukan sebagai daftar, bukan detail.
- Pada detail dan 404 publik, idle mengarahkan ke daftar FAQ awal. Waktu idle diperiksa ulang saat tab kembali aktif atau halaman dipulihkan dari cache browser. Listener dan timer dilepas saat halaman ditinggalkan.
- Pengujian browser memakai waktu nyata: pada sekitar 30 detik keadaan tetap ada, setelah lebih dari 60 detik daftar kembali kosong, accordion tertutup, dan posisi gulir nol. Detail kembali ke `/` setelah lebih dari 60 detik. Tekan tombol keyboard sekitar 40 detik setelah interaksi awal memperpanjang timer; reset baru terjadi setelah 60 detik dari tombol tersebut.
- Admin login tidak memuat penanda timer publik. Tes HTTP memastikan halaman admin lain juga tidak memuatnya. Seluruh 38 tes dan 278 assertion lulus, build Vite dan `git diff --check` lulus. Perangkat kiosk fisik dan perilaku tab terjeda pada setiap browser belum diuji secara langsung.

Tahap berikutnya yang diusulkan: Tahap 9, persiapan penerapan sesuai arahan pemilik proyek. Pelaksanaan menunggu perintah pemilik proyek.

### Audit desain Tahap 8

Design read: FAQ publik untuk pasien dan keluarga, dengan bahasa visual hangat dan tenang; reset bekerja tanpa kontrol atau bidang baru.

- Design variance 3: satu kolom FAQ tetap dipertahankan.
- Motion intensity 2: reset tidak menambah animasi atau efek baru.
- Visual density 4: informasi tetap lega dan mudah disentuh.
- Em-dash/en-dash audit: Pass, nol U+2014 dan U+2013 pada berkas UI yang diubah.
- Section-Layout-Repetition: Pass. Header identitas, pembuka, pencarian, accordion, dan footer tetap memiliki tugas berbeda; timer tidak menambah section.
- Hero discipline: Pass. Judul FAQ satu baris desktop dan dua baris pada 320 piksel, pengantar enam kata, serta pencarian terlihat pada viewport awal.

Pre-Flight Check tasteskill Section 14, setiap kotak:

1. Pass, brief inference: reset mengikuti pola pakai FAQ publik di kiosk dan ponsel.
2. Pass, dial values: variance 3, motion 2, density 4 dinyatakan di atas.
3. Pass, design system: Blade dan Tailwind memakai token PRD yang sama.
4. Pass, redesign mode: tampilan Tahap 6 dan 7 dipertahankan; perilaku idle ditambahkan tanpa komposisi baru.
5. Pass, karakter dash: tidak ada U+2014 atau U+2013 pada antarmuka yang diubah.
6. Pass, page theme lock: seluruh halaman publik tetap bertema terang.
7. Pass, color consistency: hijau PRD tetap warna utama.
8. Pass, shape consistency: radius panel dan kontrol tidak berubah.
9. Pass, button contrast: tindakan utama tetap putih pada hijau dengan kontras sekitar 6,3:1.
10. Pass, CTA wrap: label Lihat Selengkapnya dan Hapus pencarian tetap satu baris pada desktop.
11. Pass, form contrast: kolom pencarian tetap berlabel, berbatas jelas, dan memiliki fokus terlihat.
12. Pass, serif discipline: tidak ada font serif.
13. Pass, premium palette: tema memakai palet rumah sakit dari PRD.
14. Pass, italic clearance: tidak ada judul miring.
15. Pass, hero viewport: pembuka dan pencarian terlihat pada viewport awal.
16. Pass, hero top padding: jarak atas pembuka tetap di bawah 96 piksel.
17. Pass, hero stack: pembuka hanya berisi judul dan pengantar.
18. Pass, eyebrow count: tidak ada eyebrow dekoratif.
19. Pass, split-header ban: judul dan pengantar tetap satu kolom.
20. Pass, zigzag cap: tidak ada gambar dan teks selang-seling.
21. Pass, duplicate CTA: keadaan hasil kosong hanya menampilkan satu tindakan Hapus pencarian.
22. Pass, logo wall: tidak ada deretan logo.
23. Pass, bento diversity: tidak ada bento.
24. Pass, trusted-by wall: tidak ada klaim atau logo pihak lain.
25. Pass, copy audit: reset tidak menambah teks medis atau copy pemasaran.
26. Pass, motion motivated: hanya transisi kontrol yang sudah ada digunakan.
27. Pass, marquee: tidak ada marquee.
28. Pass, navigation line: header desktop satu baris dengan tinggi 80 piksel.
29. Pass, section layout repetition: struktur publik tetap sesuai fungsi dan tanpa section tambahan.
30. Pass, bento rhythm: tidak ada sel bento atau sel kosong.
31. Pass, long lists: FAQ tetap memakai accordion.
32. Pass, real images: PRD melarang gambar jawaban dan logo resmi belum tersedia; identitas teks digunakan.
33. Pass, image overlays: tidak ada gambar atau label di atas gambar.
34. Pass, photo credits: tidak ada foto dekoratif.
35. Pass, version footer: tidak ada label versi.
36. Pass, micro-meta: tidak ada kalimat dekoratif di bawah eyebrow.
37. Pass, hero strip: tidak ada strip slogan.
38. Pass, floating heading subtext: pengantar berada langsung di bawah judul.
39. Pass, scoring bars: tidak ada batang penilaian.
40. Pass, locale strips: tidak ada strip kota, cuaca, atau waktu.
41. Pass, scroll cues: tidak ada petunjuk gulir dekoratif.
42. Pass, hero version: tidak ada label versi.
43. Pass, section numbering eyebrow: tidak ada penomoran dekoratif.
44. Pass, decorative dots: tidak ada titik dekoratif.
45. Pass, repeated row borders: accordion memakai pemisah bawah tunggal.
46. Pass, content density: jawaban hanya muncul ketika FAQ dibuka.
47. Pass, quotes: tidak ada kutipan dekoratif.
48. Pass, motion claimed: intensitas 2 sesuai transisi ringan yang tampak.
49. Pass, GSAP patterns: tidak ada GSAP atau efek gulir kompleks.
50. Pass, scroll listener: pendengar scroll dipasang pada dokumen untuk memenuhi PRD, tanpa pendengar `window` atau efek visual berbasis gulir.
51. Pass, reduced motion: CSS global tetap menghormati preferensi gerak berkurang.
52. Pass, dark mode: tema tunggal terang mengikuti PRD dan theme lock.
53. Pass, mobile collapse: daftar tetap satu kolom dan telah diuji pada 320 piksel tanpa gulir horizontal.
54. Pass, viewport stability: layout memakai `dvh`, bukan tinggi layar tetap.
55. Pass, useEffect cleanup: Blade dan JavaScript ringan tidak memakai React.
56. Pass, empty/loading/error: daftar kosong, hasil kosong, dan 404 tetap memiliki pesan; reset menangani ketiganya.
57. Pass, cards omitted: FAQ dikelompokkan dalam satu bidang accordion tanpa grid kartu berulang.
58. Pass, icons: plus dan hyphen teks dipakai sebagai penanda, tanpa SVG buatan.
59. Pass, motion client leaf: tidak ada komponen animasi React.
60. Pass, AI tells: tidak ada warna ungu, tiga kartu promosi, atau section pemasaran.
61. Pass, Core Web Vitals plausibility: JavaScript lokal kecil dan timer tunggal; metrik lapangan belum diukur.
62. Pass, one design system: hanya Tailwind lokal dan token PRD.

## Tahap 7: profil admin dan penyempurnaan antarmuka

Status: selesai untuk kode pada 4 Oktober 2026. Akun dan data FAQ MySQL tidak diubah pada tahap ini.

- Route profil admin ditambahkan untuk melihat dan memperbarui nama serta email, dengan formulir password yang terpisah. Semua route profil berada di balik middleware autentikasi dan perlindungan CSRF.
- Validasi nama 100 karakter dan email unik mengabaikan akun sendiri. Email dinormalisasi, dan perubahan email mewajibkan password saat ini. Password baru minimal 12 karakter dengan konfirmasi yang cocok.
- Password disimpan melalui cast hash Laravel. Setelah perubahan password, session aktif diregenerasi dan remember token dirotasi bila sebelumnya digunakan. Password tidak diisi kembali saat validasi gagal dan tidak ditampilkan di halaman.
- Navigasi admin mobile kini dapat dibuka dan ditutup dengan elemen `details`. Link Profil tersedia pada desktop serta mobile; link lewati ke konten dan fokus keyboard yang jelas ditambahkan pada layout publik dan admin.
- Pratinjau profil dengan data contoh diperiksa di browser pada desktop dan 320 piksel, tanpa gulir horizontal pada 320 piksel. Menu mobile diuji dengan sentuhan dan Enter, accordion publik diuji dengan Enter. Berkas pratinjau sementara sudah dihapus. Perangkat kiosk fisik belum diuji.
- Seluruh 37 tes dan 271 assertion lulus. Pint, build Vite, dan `git diff --check` lulus. Tes baru mencakup pembatasan tamu, validasi nama dan email, password saat ini, email unik, hash, rotasi session dan remember token, serta tidak mem-flash password.

Tahap berikutnya yang diusulkan: Tahap 8, reset publik 60 detik dan verifikasi fitur terkait. Pelaksanaan menunggu perintah pemilik proyek.

### Audit desain Tahap 7

Design read: profil untuk satu admin rumah sakit, dengan bahasa visual tenang, jelas, dan konsisten dengan panel FAQ.

- Design variance 3: formulir memakai urutan linear agar mudah dipindai.
- Motion intensity 2: transisi hanya memberi umpan balik fokus dan tindakan.
- Visual density 4: dua tugas akun dipisahkan tanpa panel statistik.
- Em-dash/en-dash audit: Pass, nol U+2014 dan U+2013 pada berkas antarmuka yang diubah.
- Section-Layout-Repetition: Pass. Navigasi berupa rail atau menu lipat, pembuka tipografis, lalu dua formulir bertumpuk dengan pola field yang konsisten karena keduanya adalah tugas akun.
- Hero discipline: Pass. Halaman profil tidak memiliki hero pemasaran; judul satu baris pada desktop dan 320 piksel, pengantar 11 kata, dan formulir pertama langsung mengikuti pembuka. Tombol submit berada setelah field sesuai alur formulir.

Pre-Flight Check tasteskill Section 14, setiap kotak:

1. Pass, brief inference: profil admin rumah sakit mengikuti tugas identitas akun dan keamanan password.
2. Pass, dial values: variance 3, motion 2, density 4 dinyatakan di atas.
3. Pass, design system: Blade dan Tailwind memakai token PRD tanpa sistem tambahan.
4. Pass, redesign mode: layout admin yang ada diperluas tanpa mengganti bahasa visualnya.
5. Pass, karakter dash: tidak ada U+2014 atau U+2013 pada UI yang diubah.
6. Pass, page theme lock: profil dan layout tetap memakai tema terang.
7. Pass, color consistency: hijau PRD tetap warna identitas dan tindakan.
8. Pass, shape consistency: panel radius 16 piksel dan kontrol radius 12 piksel.
9. Pass, button contrast: tindakan utama memakai teks putih pada hijau dengan rasio sekitar 6,3:1.
10. Pass, CTA wrap: Simpan profil, Ubah password, dan Keluar satu baris pada desktop.
11. Pass, form contrast: label gelap, input berbatas jelas, dan fokus hijau terbaca pada putih.
12. Pass, serif discipline: tidak ada font serif.
13. Pass, premium palette: tema memakai palet rumah sakit yang ditentukan PRD.
14. Pass, italic clearance: tidak ada judul miring.
15. Pass, hero viewport: tidak ada hero pemasaran; pembuka profil dan formulir pertama terlihat pada viewport awal.
16. Pass, hero top padding: jarak atas pembuka sedang dan tidak menggeser judul ke bawah.
17. Pass, hero stack: pembuka profil hanya judul dan satu pengantar.
18. Pass, eyebrow count: profil tidak memakai eyebrow dekoratif.
19. Pass, split-header ban: judul dan pengantar tersusun vertikal.
20. Pass, zigzag cap: tidak ada pola gambar dan teks selang-seling.
21. Pass, duplicate CTA: Simpan profil dan Ubah password mengirim dua formulir berbeda.
22. Pass, logo wall: tidak ada deretan logo.
23. Pass, bento diversity: tidak ada bento.
24. Pass, trusted-by wall: tidak ada klaim atau logo pihak lain.
25. Pass, copy audit: pesan validasi menyebut field yang benar tanpa klaim medis.
26. Pass, motion motivated: transisi hanya menandai fokus dan interaksi.
27. Pass, marquee: tidak ada marquee.
28. Pass, navigation line: header desktop satu baris dan lebih rendah dari 80 piksel.
29. Pass, section layout repetition: pola field berulang hanya karena dua formulir akun yang berbeda.
30. Pass, bento rhythm: tidak ada sel bento atau sel kosong.
31. Pass, long lists: tidak ada daftar panjang pada profil.
32. Pass, real images: tidak ada gambar yang dibutuhkan untuk formulir akun; logo resmi belum diberikan.
33. Pass, image overlays: tidak ada gambar atau label di atas gambar.
34. Pass, photo credits: tidak ada foto dekoratif.
35. Pass, version footer: tidak ada label versi.
36. Pass, micro-meta: tidak ada kalimat dekoratif di bawah eyebrow.
37. Pass, hero strip: tidak ada strip slogan.
38. Pass, floating heading subtext: pengantar berada langsung di bawah judul.
39. Pass, scoring bars: tidak ada batang penilaian.
40. Pass, locale strips: tidak ada strip kota, cuaca, atau waktu.
41. Pass, scroll cues: tidak ada petunjuk gulir dekoratif.
42. Pass, hero version: tidak ada label versi.
43. Pass, section numbering eyebrow: tidak ada penomoran dekoratif.
44. Pass, decorative dots: tidak ada titik dekoratif.
45. Pass, repeated row borders: formulir memakai pemisah tunggal sebelum tindakan.
46. Pass, content density: hanya field yang diperlukan PRD yang ditampilkan.
47. Pass, quotes: tidak ada kutipan.
48. Pass, motion claimed: intensitas 2 sesuai perubahan warna kontrol yang ada.
49. Pass, GSAP patterns: tidak ada GSAP atau efek gulir kompleks.
50. Pass, scroll listener: tidak ada pendengar gulir pada tahap ini.
51. Pass, reduced motion: CSS global mengurangi transisi saat diminta.
52. Pass, dark mode: tema tunggal terang sesuai PRD dan theme lock.
53. Pass, mobile collapse: formulir satu kolom, tombol selebar bidang, menu lipat, tanpa gulir horizontal pada 320 piksel.
54. Pass, viewport stability: layout memakai `dvh`, bukan tinggi layar tetap.
55. Pass, useEffect cleanup: Blade dan JavaScript ringan tidak memakai React.
56. Pass, empty/loading/error: formulir kosong awal, galat dekat field, dan pesan sukses sesuai formulir tersedia.
57. Pass, cards omitted: dua panel hanya memisahkan identitas akun dan password yang berisiko berbeda.
58. Pass, icons: penanda menu memakai plus dan hyphen teks, tanpa SVG buatan.
59. Pass, motion client leaf: tidak ada komponen animasi React.
60. Pass, AI tells: tidak ada warna ungu, tiga kartu promosi, atau copy pemasaran.
61. Pass, Core Web Vitals plausibility: aset lokal dan tanpa font atau gambar jaringan; metrik lapangan belum diukur.
62. Pass, one design system: hanya Tailwind lokal dan token PRD yang dipakai.

## Tahap 6: halaman FAQ publik

Status: selesai untuk kode pada 4 Oktober 2026. Data MySQL tidak diubah. Halaman hanya memuat FAQ aktif sesuai urutan global yang sudah tersimpan.

- Route `/` menampilkan pencarian lokal pada pertanyaan dan jawaban singkat, accordion satu terbuka, keadaan kosong, serta disclaimer tetap. Pencarian mengabaikan huruf besar dan spasi tepi, mempertahankan urutan, dan menutup accordion saat berubah.
- Route `/faq/{faq:slug}` menampilkan jawaban lengkap yang disanitasi lagi di server. FAQ nonaktif, slug tidak ada, dan jawaban lengkap kosong mendapat halaman 404 yang ramah. Pertanyaan dan jawaban singkat tetap di-escape.
- Layout publik memakai palet PRD, identitas teks rumah sakit, aset Vite lokal, dan footer dari `config/hospital.php`. Kontak hanya tampil bila dikonfigurasi; tidak ada nomor yang ditebak.
- UI diuji di browser pada desktop dan lebar 320 piksel. Accordion, tautan detail, pencarian huruf besar, keadaan tanpa hasil, tindakan hapus, serta lebar tanpa gulir horizontal diperiksa. Ukuran target sentuh pertanyaan 114 piksel dan input 61 piksel pada 320 piksel. Kiosk fisik belum diuji.
- Seluruh 31 tes dan 222 assertion lulus, termasuk tes akses FAQ aktif, 404, sanitasi, disclaimer, dan keadaan kosong. Pint, build Vite, dan `git diff --check` lulus.
- Satu FAQ aktif pada MySQL berisi teks percobaan pada jawaban singkat dan lengkap. Konten itu berasal dari data yang sudah ada, bukan ditambahkan tahap ini, dan perlu ditinjau pengelola sebelum dipakai pasien.

Tahap berikutnya yang diusulkan: Tahap 7, profil admin dan penyempurnaan tampilan serta aksesibilitas. Timer reset publik 60 detik tetap pada Tahap 8. Pelaksanaan tahap berikutnya menunggu perintah pemilik proyek.

### Audit desain Tahap 6

Design read: FAQ publik untuk pasien dan keluarga, dengan bahasa visual hangat, tenang, lega, dan satu kolom yang mudah disentuh.

- Design variance 3: urutan baca tetap dan sederhana.
- Motion intensity 2: transisi warna hanya memberi umpan balik kontrol.
- Visual density 4: pertanyaan besar, jawaban lega, dan pencarian jelas.
- Em-dash/en-dash audit: Pass, nol U+2014 dan U+2013 dalam berkas antarmuka publik.
- Section-Layout-Repetition: Pass. Header identitas berupa baris teks; pembuka berupa judul dan pengantar; pencarian berupa field berlabel; FAQ berupa accordion satu kolom; footer berupa bidang disclaimer.
- Hero discipline: Pass. Judul desktop satu baris, judul pada 320 piksel dua baris, pengantar enam kata, dan kolom pencarian terlihat pada viewport awal desktop serta ponsel 320 x 640.

Pre-Flight Check tasteskill Section 14, setiap kotak:

1. Pass, brief inference: FAQ rumah sakit untuk pasien dan keluarga menjadi acuan tata letak.
2. Pass, dial values: variance 3, motion 2, density 4 dijelaskan di atas.
3. Pass, design system: Blade dan Tailwind memakai token PRD tanpa sistem tambahan.
4. Pass, redesign mode: halaman default Laravel diganti pada route publik sesuai arah mockup yang disetujui.
5. Pass, karakter dash: tidak ada U+2014 atau U+2013 pada antarmuka publik.
6. Pass, page theme lock: seluruh halaman publik memakai tema terang.
7. Pass, color consistency: hijau PRD konsisten sebagai warna tindakan dan identitas.
8. Pass, shape consistency: bidang utama radius 16 piksel, kontrol radius 12 piksel.
9. Pass, button contrast: tindakan utama putih pada hijau memiliki rasio sekitar 6,3:1.
10. Pass, CTA wrap: label Lihat Selengkapnya, Kembali ke FAQ, dan Hapus pencarian tetap satu baris pada desktop.
11. Pass, form contrast: input berbatas jelas, label gelap, placeholder terbaca, dan fokus hijau.
12. Pass, serif discipline: tidak ada font serif.
13. Pass, premium palette: warna mengikuti PRD rumah sakit, bukan palet premium konsumen.
14. Pass, italic clearance: tidak ada judul miring.
15. Pass, hero viewport: pembuka dan pencarian terlihat tanpa gulir pada desktop dan ponsel uji.
16. Pass, hero top padding: jarak atas pembuka kurang dari 96 piksel.
17. Pass, hero stack: pembuka hanya judul dan pengantar, diikuti fungsi pencarian.
18. Pass, eyebrow count: tidak ada eyebrow dekoratif.
19. Pass, split-header ban: judul dan pengantar ditumpuk dalam satu kolom.
20. Pass, zigzag cap: tidak ada gambar dan teks selang-seling.
21. Pass, duplicate CTA: pada hasil kosong hanya satu tindakan Hapus pencarian yang terlihat.
22. Pass, logo wall: tidak ada deretan logo.
23. Pass, bento diversity: tidak ada bento yang memerlukan variasi sel.
24. Pass, trusted-by wall: tidak ada klaim atau logo pihak lain.
25. Pass, copy audit: teks sesuai PRD; jawaban medis tidak dibuat dalam kode.
26. Pass, motion motivated: perubahan warna hanya menandai fokus dan sentuhan.
27. Pass, marquee: tidak ada marquee.
28. Pass, navigation line: header desktop satu baris dengan tinggi 80 piksel.
29. Pass, section layout repetition: identitas, pembuka, pencarian, accordion, dan footer memiliki fungsi serta susunan berbeda.
30. Pass, bento rhythm: tidak ada bento atau sel kosong.
31. Pass, long lists: FAQ menggunakan accordion, bukan daftar teks datar.
32. Pass, real images: PRD melarang gambar jawaban dan logo resmi belum disediakan; identitas teks dipakai.
33. Pass, image overlays: tidak ada gambar atau label di atas gambar.
34. Pass, photo credits: tidak ada foto dekoratif.
35. Pass, version footer: tidak ada label versi.
36. Pass, micro-meta: tidak ada kalimat dekoratif di bawah eyebrow.
37. Pass, hero strip: tidak ada strip slogan.
38. Pass, floating heading subtext: pengantar berada langsung di bawah judul.
39. Pass, scoring bars: tidak ada batang penilaian.
40. Pass, locale strips: tidak ada strip kota, cuaca, atau waktu.
41. Pass, scroll cues: tidak ada petunjuk gulir dekoratif.
42. Pass, hero version: tidak ada label versi di pembuka.
43. Pass, section numbering eyebrow: tidak ada nomor dekoratif.
44. Pass, decorative dots: tidak ada titik dekoratif.
45. Pass, repeated row borders: accordion memakai pemisah bawah tunggal.
46. Pass, content density: pertanyaan satu kolom dan jawaban hanya muncul saat dibuka.
47. Pass, quotes: tidak ada kutipan dekoratif.
48. Pass, motion claimed: intensitas 2 sesuai transisi kontrol yang benar-benar ada.
49. Pass, GSAP patterns: tidak ada GSAP atau efek gulir kompleks.
50. Pass, scroll listener: belum ada timer atau pendengar gulir pada tahap ini.
51. Pass, reduced motion: CSS global menekan transisi ketika diminta.
52. Pass, dark mode: tema tunggal terang sesuai PRD dan theme lock.
53. Pass, mobile collapse: halaman satu kolom pada 320 piksel dan tidak melebar.
54. Pass, viewport stability: layout memakai `dvh`, bukan tinggi layar tetap.
55. Pass, useEffect cleanup: Blade dan JavaScript ringan tidak memakai React.
56. Pass, empty/loading/error: daftar kosong, hasil cari kosong, dan 404 memiliki pesan serta tindakan yang jelas.
57. Pass, cards omitted: satu bidang accordion mengelompokkan FAQ tanpa grid kartu berulang.
58. Pass, icons: tanda plus dan hyphen teks dipakai untuk keadaan accordion; tidak ada SVG buatan.
59. Pass, motion client leaf: tidak ada komponen animasi React.
60. Pass, AI tells: tidak ada tiga kartu promosi, warna ungu, atau section pemasaran.
61. Pass, Core Web Vitals plausibility: aset lokal kecil tanpa font atau gambar jaringan; metrik lapangan belum diukur.
62. Pass, one design system: hanya Tailwind lokal dan token PRD.

## Tahap 5: pengurutan FAQ dan dashboard

Status: selesai untuk kode pada 4 Oktober 2026. Data FAQ MySQL tidak diubah pada tahap ini. Pemeriksaan baca saja menemukan sembilan FAQ, satu aktif, sehingga dashboard akan memakai data yang sudah ada.

- Halaman dashboard menampilkan Total FAQ, FAQ Aktif, FAQ Nonaktif, tombol Tambah FAQ, dan maksimal lima FAQ terbaru diperbarui dengan status, waktu, serta tindakan Edit. Keadaan tanpa FAQ juga memiliki tindakan Tambah FAQ.
- Daftar FAQ mendapat tombol Pindah pada setiap record. Pada tab Semua tanpa pencarian, urutan dapat diubah melalui pointer pada mouse atau layar sentuh dan tombol panah atas/bawah pada keyboard. Pada daftar terfilter, tombol nonaktif dan alasan ditampilkan.
- Endpoint `PUT /admin/faqs/reorder` menerima seluruh ID dalam urutan baru dan snapshot daftar. Validasi menolak ID duplikat atau bukan bilangan bulat; server menolak himpunan ID atau snapshot yang sudah tidak cocok dan meminta pemuatan ulang.
- Penyimpanan urutan memakai transaksi dan kunci baris, lalu menulis `sort_order` berurutan mulai 1 tanpa mengubah waktu pembaruan konten. Jika respons gagal, tampilan kembali ke urutan sebelumnya dan menampilkan pesan. Penghapusan FAQ kini merapikan sisa urutan dalam transaksi.
- Tidak ada dependensi baru. Seluruh 28 tes dan 187 assertion lulus; Pint, build Vite, dan `git diff --check` lulus. Tes mencakup urutan aktif dan nonaktif, input invalid, konflik data, rollback saat penyimpanan gagal, filter, penghapusan, angka dashboard, serta lima perubahan terakhir. Interaksi pointer dan keyboard pada perangkat fisik belum diuji di browser.

Tahap berikutnya yang diusulkan: Tahap 6, halaman publik dengan pencarian, accordion, detail, dan disclaimer sesuai mockup yang telah disetujui. Pelaksanaan menunggu perintah pemilik proyek.

### Audit desain Tahap 5

Design read: dashboard dan daftar kerja untuk satu admin rumah sakit, dengan bahasa visual tenang, ringkas, dan konsisten dengan antarmuka FAQ yang telah dibuat.

- Design variance 3: struktur tetap dan prioritas tugas jelas.
- Motion intensity 2: gerakan hanya mengikuti pengurutan dan umpan balik kontrol.
- Visual density 4: tiga angka ringkasan dan lima perubahan terakhir mudah dipindai.
- Em-dash/en-dash audit: Pass, nol U+2014 dan U+2013 pada berkas UI yang diubah.
- Section-Layout-Repetition: Pass. Dashboard memakai pembuka, strip tiga angka dalam satu bidang, dan daftar perubahan terbaru. Halaman FAQ memakai pembuka, panel cari dan filter, lalu daftar kartu administratif.
- Hero discipline: Pass, kedua halaman adalah panel kerja tanpa hero pemasaran; judul satu baris pada desktop, pengantar dashboard singkat, dan tindakan utama berada di pembuka saat ada data.

Pre-Flight Check tasteskill Section 14, setiap kotak:

1. Pass, brief inference: panel admin FAQ rumah sakit mengikuti tugas pengelolaan aktual.
2. Pass, dial values: variance 3, motion 2, density 4 dinyatakan di atas.
3. Pass, design system: Blade dan Tailwind memakai token warna PRD yang sama.
4. Pass, redesign mode: kerangka Tahap 4 diperiksa dan diperluas tanpa mengganti pola navigasi.
5. Pass, karakter dash: tidak ada U+2014 atau U+2013 pada UI Tahap 5.
6. Pass, page theme lock: dashboard dan daftar memakai tema terang.
7. Pass, color consistency: hijau PRD tetap aksen utama, merah hanya untuk galat dan hapus.
8. Pass, shape consistency: bidang radius 16 piksel dan kontrol radius 12 piksel.
9. Pass, button contrast: tindakan utama memakai putih pada hijau gelap dan tombol sekunder berteks hijau gelap.
10. Pass, CTA wrap: label Tambah FAQ, Edit, dan Pindah singkat pada desktop.
11. Pass, form contrast: kolom cari mempertahankan batas dan fokus yang jelas.
12. Pass, serif discipline: tidak ada font serif.
13. Pass, premium palette: konteks rumah sakit memakai palet PRD, bukan palet konsumen premium.
14. Pass, italic clearance: tidak ada judul miring.
15. Pass, hero viewport: tidak ada hero; tindakan utama berada dekat judul panel.
16. Pass, hero top padding: pembuka panel tidak didorong jauh ke bawah viewport.
17. Pass, hero stack: pembuka dashboard hanya eyebrow, judul, pengantar, dan tindakan utama.
18. Pass, eyebrow count: satu eyebrow pada pembuka tiap halaman.
19. Pass, split-header ban: judul dan pengantar tersusun vertikal.
20. Pass, zigzag cap: tidak ada gambar dan teks zigzag.
21. Pass, duplicate CTA: Tambah FAQ dan Lihat semua FAQ memiliki tujuan berbeda; pada keadaan kosong hanya ada satu tindakan tambah.
22. Pass, logo wall: tidak ada deretan logo.
23. Pass, bento diversity: ringkasan memakai satu bidang informatif, bukan bento dekoratif.
24. Pass, trusted-by wall: tidak ada klaim atau logo pihak lain.
25. Pass, copy audit: label urut, status, dan pesan gagal jelas serta tidak mengarang informasi medis.
26. Pass, motion motivated: perpindahan dan penanda target menunjukkan aksi urut.
27. Pass, marquee: tidak ada marquee.
28. Pass, navigation line: header desktop tetap satu baris.
29. Pass, section layout repetition: pembuka, angka ringkas, daftar terbaru, filter, dan kartu memiliki tugas serta komposisi berbeda.
30. Pass, bento rhythm: tidak ada bento atau sel kosong.
31. Pass, long lists: FAQ memakai kartu sesuai PRD; dashboard membatasi daftar terbaru menjadi lima.
32. Pass, real images: tidak ada gambar jawaban atau dekorasi yang diperlukan untuk panel kerja.
33. Pass, image overlays: tidak ada gambar berlabel.
34. Pass, photo credits: tidak ada foto dekoratif.
35. Pass, version footer: tidak ada label versi.
36. Pass, micro-meta: tidak ada kalimat dekoratif di bawah eyebrow.
37. Pass, hero strip: tidak ada strip slogan.
38. Pass, floating heading subtext: tidak ada teks mengambang di sisi judul.
39. Pass, scoring bars: angka FAQ bukan batang penilaian.
40. Pass, locale strips: tidak ada strip kota, cuaca, atau jam.
41. Pass, scroll cues: tidak ada petunjuk gulir dekoratif.
42. Pass, hero version: tidak ada label versi.
43. Pass, section numbering eyebrow: tidak ada nomor bagian dekoratif.
44. Pass, decorative dots: tidak ada titik dekoratif.
45. Pass, repeated row borders: daftar terbaru memakai pemisah tunggal di dalam satu bidang.
46. Pass, content density: tiga angka dan lima record terbaru sesuai kebutuhan dashboard PRD.
47. Pass, quotes: tidak ada kutipan.
48. Pass, motion claimed: intensitas 2 sesuai penanda drag dan transisi ringan.
49. Pass, GSAP patterns: tidak ada GSAP atau animasi gulir kompleks.
50. Pass, scroll listener: tidak ada pendengar acara gulir.
51. Pass, reduced motion: aturan CSS global menekan transisi ketika diminta.
52. Pass, dark mode: tema tunggal terang sesuai theme lock; mode gelap tidak diminta.
53. Pass, mobile collapse: ringkasan menumpuk dan tindakan pada kartu membungkus.
54. Pass, viewport stability: layout menggunakan `dvh`, tanpa tinggi layar tetap.
55. Pass, useEffect cleanup: aplikasi Blade tidak memakai React atau `useEffect`.
56. Pass, empty/loading/error: dashboard kosong, proses menyimpan urutan, konflik, dan gagal jaringan mempunyai respons.
57. Pass, cards omitted: dashboard memakai satu strip ringkasan dan satu daftar; kartu FAQ tetap dipakai sesuai PRD.
58. Pass, icons: tombol Pindah memakai teks, tanpa ikon campuran atau SVG buatan.
59. Pass, motion client leaf: tidak ada komponen animasi React.
60. Pass, AI tells: tidak ada tiga kartu promosi, warna ungu, atau bagian pemasaran.
61. Pass, Core Web Vitals plausibility: aset lokal kecil dan tanpa gambar jaringan; metrik lapangan belum diukur.
62. Pass, one design system: hanya token PRD dan Tailwind lokal yang digunakan.

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
