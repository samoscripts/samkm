FROM php:8.2-cli

# Instalacja zależności systemowych i rozszerzeń PHP
RUN apt-get update \
    && apt-get -y upgrade \
    && apt-get install -y --no-install-recommends \
    unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Instalacja Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug


# Kopiowanie konfiguracji Xdebug
COPY .docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Domyślne polecenie (np. uruchomienie serwera)
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

