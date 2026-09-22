FROM php:8.3-fpm-bookworm@sha256:cfdaca428b2c53858e048fabb0e7afafc01e5156c289f55197d383040c7c8435

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libwebp-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" exif gd intl mbstring mysqli opcache zip \
    && rm -rf /var/lib/apt/lists/*

COPY 99-g5.ini /usr/local/etc/php/conf.d/99-g5.ini
