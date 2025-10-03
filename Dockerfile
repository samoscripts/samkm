FROM php:8.2-cli

# Instalacja zależności systemowych i rozszerzeń PHP
RUN apt-get update \
    && apt-get -y upgrade \
    && apt-get install -y --no-install-recommends \
        unzip git curl libpq-dev build-essential \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Instalacja Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Kopiowanie konfiguracji Xdebug
COPY .docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalacja NVM + Node.js 20
ENV NVM_DIR=/root/.nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.6/install.sh | bash \
    && . $NVM_DIR/nvm.sh \
    && nvm install 20 \
    && nvm use 20 \
    && nvm alias default 20

# Dodanie Node do PATH
ENV PATH=$NVM_DIR/versions/node/v20.*/bin:$PATH

# Sprawdzenie wersji Node i npm (opcjonalne)
RUN node -v
RUN npm -v

WORKDIR /var/www

# Domyślne polecenie (np. uruchomienie serwera)
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
