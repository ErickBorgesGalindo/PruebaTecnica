FROM php:8.2-cli

# 1. Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libssl-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Instalar extensión MongoDB
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions
RUN install-php-extensions mongodb

# 3. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --ignore-platform-req=ext-mongodb

# Cache bust for source code changes
ARG CACHE_BUST=1
COPY . .
RUN composer dump-autoload --optimize --no-dev

EXPOSE 8000

CMD printf "APP_KEY=${APP_KEY:-}\nAPP_ENV=production\nAPP_DEBUG=true\nDB_CONNECTION=mongodb\nMONGODB_URI=${MONGODB_URI:-}\nMONGODB_DATABASE=${MONGODB_DATABASE:-prueba_tecnica}\nJWT_SECRET=${JWT_SECRET:-}\nCACHE_STORE=array\nSESSION_DRIVER=array\nQUEUE_CONNECTION=sync\n" > .env \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan serve --host=0.0.0.0 --port=$PORT
