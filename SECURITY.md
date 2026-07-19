# Keamanan dan Respons Insiden

## Tindakan segera setelah banner disusupi

1. Aktifkan maintenance mode bila perubahan berbahaya masih muncul:

```bash
php artisan down --secret="buat-token-acak-yang-panjang"
```

2. Sebelum membersihkan data, simpan salinan database, `storage`, dan log web server untuk kebutuhan investigasi.
3. Rotasi password seluruh akun `admin`, `super_admin`, dan `panel_user`. Jangan menggunakan password dari seeder pada production.
4. Keluarkan semua sesi aktif setelah password dirotasi:

```bash
php artisan tinker --execute="DB::table('sessions')->delete();"
```

5. Audit tabel `users`, `roles`, `model_has_roles`, dan `role_has_permissions`. Nonaktifkan akun atau role yang tidak dikenali.
6. Hapus/nonaktifkan banner berbahaya, lalu bersihkan cache:

```bash
php artisan cache:clear
php artisan view:clear
```

7. Deploy migration terbaru dan pastikan seluruh pengguna panel menyelesaikan setup MFA berbasis authenticator app.
   Pindahkan bukti pembayaran lama keluar dari storage publik:

```bash
php artisan security:migrate-payment-proofs
```

8. Periksa access log untuk request ke `/admin`, `/livewire/update`, dan file pada `/storage/home-hero`. Catat IP, waktu, user-agent, serta akun terkait.
9. Bandingkan file aplikasi dengan sumber tepercaya dan pindai server untuk web shell. Periksa khususnya `public`, `storage/app/public`, cron, supervisor, dan akun SSH.
10. Rotasi credential database, SMTP, object storage, dan deployment jika log menunjukkan credential server ikut bocor. Jangan mengganti `APP_KEY` tanpa rencana migrasi karena data terenkripsi akan tidak terbaca.
11. Setelah verifikasi selesai:

```bash
php artisan optimize
php artisan up
```

## Proteksi banner

- Hanya role `super_admin` yang dapat membuat, mengubah, atau menghapus banner.
- Hanya role `super_admin` yang dapat mengelola pengguna dan role; role `admin` tidak dapat menaikkan hak aksesnya sendiri.
- Password bawaan historis ditolak pada seluruh jalur autentikasi ketika `APP_ENV=production`. Pemilik akun harus memakai alur reset password.
- Upload dibatasi ke JPEG, PNG, dan WebP dengan ukuran maksimum 5 MB dan dimensi minimum 1200×400.
- Gambar harus berasal dari direktori lokal `storage/app/public/home-hero`.
- Link banner hanya diizinkan menuju host pada `APP_URL` atau `HERO_ALLOWED_LINK_HOSTS`.
- Perubahan baru dicatat di tabel `home_hero_image_audits`.

Lihat audit perubahan setelah fitur ini terpasang:

```bash
php artisan security:hero-audit --limit=100
```

Audit ini tidak bersifat retroaktif; insiden sebelum deployment harus ditelusuri dari database backup dan access log.

## Konfigurasi production

```dotenv
APP_ENV=production
APP_DEBUG=false
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
HERO_ALLOWED_LINK_HOSTS=hastanaindonesia.org,www.hastanaindonesia.org
```

Jalankan pemeriksaan:

```bash
php artisan app:production-check
```

Untuk Nginx, blokir eksekusi script dari direktori upload:

```nginx
location ~* ^/storage/.*\.(php|phtml|phar|cgi|pl|py|sh)$ {
    deny all;
    return 404;
}
```

Apache dilindungi melalui `storage/app/public/.htaccess`.
