@servers(['production' => 'deployer@45.32.187.103'])

@task('deploy', ['on' => 'production'])

cd /var/www/videofabrikasi.com/html

php artisan route:clear
php artisan config:clear
git pull
@if ($npm)
    php artisan storage:link
    npm install
    npm run production
@endif
composer install
composer dump-autoload
php artisan route:cache
php artisan config:cache
php artisan opcache:clear
php artisan queue:restart
@endtask

@task('migrate', ['on' => 'production'])
cd /var/www/videofabrikasi.com/html
php artisan migrate --force
php artisan db:seed --force
@endtask

@task('migrate-reset', ['on' => 'production'])
cd /var/www/videofabrikasi.com/html
php artisan migrate:refresh --force
php artisan db:seed --force
@endtask