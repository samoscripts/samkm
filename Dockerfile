# Dockerfile
FROM php:8.3-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
	httpie \
    unzip \
    vim \
    libicu-dev \
    libpq-dev \
    systemd
# Update the package list and install dependencies
RUN docker-php-ext-install intl calendar

#RUN apt install -y nodejs npm
#RUN npm install -D tailwindcss
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Skopiowanie plików konfiguracyjnych Apache
#COPY ./.docker/php_service/etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
# Skopiowanie plików projektu do katalogu Apache
COPY . /var/www/


# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug


RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

ENV APP_ENV=dev XDEBUG_MODE=develop,debug,coverage

RUN deluser www-data
RUN \
    addgroup --gid 1002 www-data && \
    adduser --uid 1002 --gid 1002 --disabled-password --gecos "" www-data

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Ensure the directory exists and change ownership of the project files
# RUN mkdir -p /var/www && chown -R www-data:www-data /var/www

# Switch to the new user
USER www-data

# Install PHP dependencies
# RUN composer install

# Expose ports for HTTP and HTTPS
EXPOSE 80 443 9000 9003