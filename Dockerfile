FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
    libjpeg-dev libfreetype6-dev supervisor libicu-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl pdo_pgsql

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --optimize-autoloader

RUN cp .env.example .env && \
    sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env && \
    sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=mysql/' .env && \
    sed -i 's/# DB_PORT=3306/DB_PORT=3306/' .env && \
    sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=kodlab/' .env && \
    sed -i 's/# DB_USERNAME=root/DB_USERNAME=kodlab_user/' .env && \
    sed -i 's/# DB_PASSWORD=/DB_PASSWORD=kodlab_pass/' .env && \
    php artisan key:generate && \
    php artisan storage:link

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
