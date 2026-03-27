# ============================================================
# Stage 1: Node — Build frontend assets (Vite + TailwindCSS)
# ============================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --prefer-offline

COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources/ resources/
COPY public/ public/

RUN npm run build

# ============================================================
# Stage 2: Composer — Install PHP dependencies
# ============================================================
FROM composer:2.8 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

COPY . .
RUN composer dump-autoload --optimize --no-dev

# ============================================================
# Stage 3: Production image
# ============================================================
FROM php:8.2-fpm-alpine AS production

LABEL maintainer="ToneDev"
LABEL description="E-Commerce Portfolio — Laravel 12"

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
        nginx \
        supervisor \
        sqlite \
        sqlite-dev \
        libpng \
        libpng-dev \
        libjpeg-turbo \
        libjpeg-turbo-dev \
        libwebp \
        libwebp-dev \
        freetype \
        freetype-dev \
        oniguruma-dev \
        zip \
        unzip \
        curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        opcache \
    && apk del libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

# Copy application files from previous stages
COPY --from=composer-builder --chown=www-data:www-data /app .
COPY --from=node-builder      --chown=www-data:www-data /app/public/build public/build/

# Copy configuration files
COPY docker/nginx/default.conf    /etc/nginx/http.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf
COPY docker/php/php.ini           $PHP_INI_DIR/conf.d/custom.ini
COPY docker/entrypoint.sh         /entrypoint.sh

RUN chmod +x /entrypoint.sh \
    && mkdir -p storage/framework/{cache,sessions,views} \
               storage/logs \
               bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
