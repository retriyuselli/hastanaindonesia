# BlogSeeder (Database Seed)

Dokumen ini menjelaskan seeder blog yang berada di `database/seeders/BlogSeeder.php`: tujuan, perilaku seeding, daftar artikel, dan cara menjalankannya.

## Lokasi

- File: `database/seeders/BlogSeeder.php`
- Class: `Database\Seeders\BlogSeeder`

## Tujuan

`BlogSeeder` mengisi tabel blog dengan 10 artikel bertema Wedding Organizer (WO) menggunakan konten HTML, lengkap dengan metadata SEO dan metrik engagement yang realistis.

## Perilaku Seeder (Ringkas)

- Hanya berjalan pada environment `local` dan `testing`.
  - Jika bukan `local/testing`, seeder akan dilewati.
- Mengosongkan data blog lama:
  - `Blog::truncate()` dijalankan dengan mematikan/menyalakan kembali foreign key checks.
- Mengambil referensi:
  - Kategori: `BlogCategory::all()`
  - Author aktif: `Author::where('is_active', true)->get()`
  - Jika kategori atau author kosong, seeder berhenti dan menampilkan pesan agar menjalankan `BlogCategorySeeder` dan `AuthorSeeder` lebih dulu.
- Saat membuat blog:
  - `slug` dibuat dari `title` menggunakan `Str::slug(...)`.
  - `blog_category_id` dan `author_id` dipilih secara random dari data yang ada.
  - `views_count`, `likes_count`, `comments_count` dibuat random dan `engagement_score` dihitung dari data tersebut.
  - `published_at` di-set menggunakan `Carbon::now()->subDays(...)`.

## Daftar Artikel yang Diseed

1. Panduan Lengkap Wedding Organizer untuk Pernikahan Anti Gagal (2026)
2. 7 Kesalahan Fatal Saat Menikah Tanpa Wedding Organizer
3. Cara Memilih Wedding Organizer yang Tepat (Checklist Lengkap)
4. Rahasia Pernikahan Lancar Tanpa Drama ala WO Profesional
5. Cerita Nyata: Pernikahan Hampir Gagal yang Berhasil Diselamatkan WO
6. Contoh Rundown Pernikahan yang Benar (Dari Akad sampai Resepsi)
7. Berapa Biaya Wedding Organizer di Indonesia? (Update 2026)
8. WO vs Tanpa WO: Mana yang Lebih Hemat dan Aman?
9. Peran Penting Vendor dalam Pernikahan (Dan Cara WO Mengaturnya)
10. Standar Wedding Organizer Profesional di Indonesia

## Cara Menjalankan

Pastikan sudah ada data kategori blog dan author aktif.

```bash
php artisan db:seed --class=BlogSeeder
```

Jika environment aplikasi bukan `local` atau `testing`, seeder tidak akan berjalan.

## Struktur Data per Artikel (Field Utama)

Setiap entri blog yang dibuat minimal berisi:

- `title`
- `slug` (dibuat otomatis dari `title`)
- `featured_image` (URL)
- `excerpt`
- `content` (HTML string)
- `meta_title`
- `meta_description`
- `tags` (array)
- `seo_keywords` (array)
- `read_time` (angka)
- `is_published`, `is_featured`
- `status`
- `published_at`
- `blog_category_id`, `author_id`
- `views_count`, `likes_count`, `comments_count`, `engagement_score`

## Catatan Konten

- `content` menggunakan HTML (misalnya `<h2>`, `<h3>`, `<p>`, `<ul><li>...</li></ul>`).
- Judul artikel dipakai sebagai sumber slug, jadi mengubah `title` akan mengubah `slug`.

## Pemeriksaan Jumlah Kata (Opsional)

Jika ingin menghitung jumlah kata dari 10 artikel yang baru diseed (mengabaikan tag HTML), jalankan:

```bash
php -r 'require "vendor/autoload.php"; $app=require "bootstrap/app.php"; $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); $blogs=App\Models\Blog::orderBy("id","desc")->take(10)->get()->reverse(); foreach($blogs as $b){$text=strip_tags($b->content); $count=str_word_count($text); echo $b->title.": ".$count." words\n"; }'
```

## Troubleshooting

- Seeder tidak jalan:
  - Pastikan environment `APP_ENV` adalah `local` atau `testing`.
- Muncul pesan kategori/author kosong:
  - Jalankan `BlogCategorySeeder` dan `AuthorSeeder`, lalu ulangi `BlogSeeder`.
- Data blog lama hilang setelah seeding:
  - Ini memang perilaku seeder karena melakukan `truncate()` sebelum membuat data baru.
