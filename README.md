# HASTANA Indonesia

Aplikasi web Himpunan Perusahaan Penata Acara Seluruh Indonesia. Dibangun dengan Laravel 12, Blade, Livewire, Filament, Tailwind CSS, dan Vite.

## Persyaratan

- PHP 8.2 atau lebih baru beserta ekstensi yang dibutuhkan Laravel
- Composer
- Node.js dan npm
- MySQL
- MAMP atau web server lokal lain

## Instalasi dengan MAMP

1. Pastikan proyek berada di `/Applications/MAMP/htdocs/hastanaindonesia`.
2. Atur document root virtual host ke folder `public`, bukan root proyek.
3. Buat database MySQL bernama `hastana_indonesia`.
4. Jalankan:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
```

Sesuaikan koneksi database di `.env`. MAMP umumnya menggunakan port MySQL `8889`, tetapi instalasi tertentu memakai `3306`.

```dotenv
APP_URL=http://hastanaindonesia.test
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=hastana_indonesia
DB_USERNAME=root
DB_PASSWORD=root
```

Jika tidak menggunakan virtual host, sesuaikan `APP_URL` dengan URL MAMP yang digunakan.

## Menjalankan saat development

Jalankan seluruh proses development:

```bash
composer dev
```

Atau gunakan Apache MAMP dan jalankan Vite secara terpisah:

```bash
npm run dev
php artisan queue:listen --tries=1
```

Panel admin tersedia di `/admin`.

Seeder membuat akun development, termasuk `superadmin@hastana.com` dan `admin@hastana.com`, dengan password awal `password123`. Jangan menjalankan seeder data contoh di production dan segera ganti seluruh password tersebut bila database digunakan bersama.

## Pengujian dan kualitas

```bash
composer test
npm run build
./vendor/bin/pint --test
```

## Persiapan production

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan optimize
php artisan app:production-check
```

Gunakan nilai berikut pada environment production:

```dotenv
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=warning
```

Pastikan queue worker aktif karena konfigurasi default menggunakan queue database. Contoh konfigurasi Supervisor:

```ini
[program:hastana-worker]
command=/usr/bin/php /var/www/hastanaindonesia/artisan queue:work --sleep=3 --tries=3 --max-time=3600
directory=/var/www/hastanaindonesia
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/supervisor/hastana-worker.log
```

Tambahkan scheduler Laravel ke cron:

```cron
* * * * * cd /var/www/hastanaindonesia && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

Backup database dan file upload harus disimpan di lokasi terpisah dari document root. Contoh backup MySQL:

```bash
mysqldump --single-transaction --routines --triggers \
  -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p \
  "$DB_DATABASE" | gzip > "/secure-backups/hastana-$(date +%F-%H%M).sql.gz"
```

Jadwalkan backup otomatis, enkripsi bila disimpan di luar server, tetapkan masa retensi, dan lakukan uji restore secara berkala. Route demo dan debug hanya didaftarkan pada environment `local` atau `testing`.

Jangan deploy `.env`, `storage_backup`, log, cache runtime, `node_modules`, atau `vendor` dari mesin development.
