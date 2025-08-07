FROM php:8.3-fpm-alpine3.21 AS desafio-me

RUN apk update && apk upgrade
RUN apk add autoconf
RUN apk add gcc
RUN apk add --no-cache icu-dev && \
    docker-php-ext-install intl && \
    docker-php-ext-enable intl

RUN apk add --no-cache \
    supervisor \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    && docker-php-ext-install \
    pdo_pgsql \
    mbstring \
    zip \
    gd \
    opcache \
    && docker-php-ext-enable opcache

RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.jit_buffer_size=256M'; \ 
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.max_wasted_percentage=10'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.use_cwd=0'; \
    # echo 'opcache.preload=/var/www/html/preload.php'; \
    # echo 'opcache.preload_user=www-data'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

RUN { \
    echo 'expose_php=Off'; \
    echo 'memory_limit=256M'; \
    echo 'upload_max_filesize=100M'; \
    echo 'post_max_size=50M'; \
    echo 'max_execution_time=600'; \
    } > /usr/local/etc/php/conf.d/laravel.ini

RUN apk add supervisor

COPY ./ /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/storage/framework/views/ /var/www/html/storage/logs/ /var/www/html/storage/framework/sessions/
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/storage/framework/views/ /var/www/html/storage/logs/ /var/www/html/storage/framework/sessions/

RUN mkdir -p /run/php/
RUN touch /run/php/php-fpm.pid

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer 

WORKDIR /var/www/html

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

RUN composer install --no-dev -o -a
