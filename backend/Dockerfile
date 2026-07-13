FROM php:8.2-cli

# Cache bust: 2026-07-13-rebuild
RUN echo "rebuild"

# Instalar extensión MongoDB de forma confiable
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

RUN install-php-extensions mongodb

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --no-dev --no-scripts --prefer-dist --ignore-platform-req=ext-mongodb

COPY . .

RUN composer dump-autoload --optimize --no-dev

EXPOSE 8000

CMD cp .env.example .env && php artisan key:generate --force && php artisan config:clear && php artisan serve --host=0.0.0.0 --port=$PORT
