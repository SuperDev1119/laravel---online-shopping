# web: (composer warmup) && vendor/bin/heroku-php-apache2 public
web: (composer warmup) && vendor/bin/heroku-php-nginx -C nginx.conf public/
worker: DATABASE_FOLLOWER_NAME= php artisan horizon
