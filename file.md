cd /home/u380354370/domains/hastanaindonesia.id/public_html

# 1. Clear semua cache Laravel
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

# 2. Cache config (untuk produksi, penting!)
php artisan config:cache

# 3. Cache route (jika route tidak menggunakan closure)
php artisan route:cache

# 4. Cache view
php artisan view:cache

# 5. Optimize Laravel (opsional, menggabungkan cache config & route)
php artisan optimize

# 6. Pastikan storage link (jika perlu)
php artisan storage:link