# ─────────────────────────────────────────────
# Stage 1: Builder — install deps & build assets
# ─────────────────────────────────────────────
FROM php:8.3-fpm-alpine AS builder

WORKDIR /var/www

# Install build-time system dependencies (apk for Alpine)
RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libpng-dev \
    libpq-dev \
    oniguruma-dev \
    libzip-dev \
    jpeg-dev \
    freetype-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        mbstring zip exif pcntl \
        pdo pdo_pgsql gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy dependency manifests first (cache layer)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY package.json package-lock.json ./
RUN npm ci

# Copy full source
COPY . .

# Generate optimised autoload + run post-install scripts
RUN composer dump-autoload --optimize --no-dev

# Build frontend assets
RUN npm run build

# ─────────────────────────────────────────────
# Stage 2: Production — runtime only
# ─────────────────────────────────────────────
FROM php:8.3-fpm-alpine AS production

WORKDIR /var/www

# Runtime system dependencies only
RUN apk add --no-cache \
    libpng \
    libpq \
    oniguruma \
    libzip \
    freetype \
    libjpeg-turbo \
    bash

# Copy PHP extensions compiled in builder stage
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/    /usr/local/etc/php/conf.d/

# Add non-root user (Alpine uses addgroup/adduser)
RUN addgroup -g 1000 www && \
    adduser -u 1000 -s /bin/bash -G www -D www

# Copy application (from builder — includes vendor, public/build)
COPY --from=builder --chown=www:www /var/www /var/www

# Copy entrypoint
COPY --chown=www:www docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER www

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
