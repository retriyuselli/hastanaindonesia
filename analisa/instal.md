php artisan migrate --path=database/migrations/

cd /home/u380354370/domains/hastana.maknawedding.id/public_html

cd /home/u380354370/domains/hastanaindonesia.id/public_html

cd /home/u380354370/domains/demo.hastanaindonesia.id/public_html

php artisan db:seed --class=AdminUserSeeder

# Server Deployment Commands (Run setelah git pull)

git pull origin main
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
php artisan optimize
