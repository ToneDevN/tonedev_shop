# ─────────────────────────────────────────────
# Stage 1: Builder — install deps & build assets
# ─────────────────────────────────────────────
FROM php:8.3-fpm-alpine AS builder

WORKDIR /var/www

# Install build-time system dependencies
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
    libwebp-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        mbstring zip exif pcntl \
        pdo pdo_pgsql gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG INSTALL_DEV=false

# Copy dependency manifests
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN if [ "$INSTALL_DEV" = "true" ] ; then \
        composer install --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs; \
    else \
        composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs; \
    fi

# Build assets
COPY package.json package-lock.json ./
RUN npm ci --prefer-offline

COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources/ resources/
COPY public/ public/
RUN npm run build

# Copy full source
COPY . .

# Generate autoloader
RUN if [ "$INSTALL_DEV" = "true" ] ; then \
        composer dump-autoload --optimize; \
    else \
        composer dump-autoload --optimize --no-dev; \
    fi

# ─────────────────────────────────────────────
# Stage 2: Production — runtime only
# ─────────────────────────────────────────────
FROM php:8.3-fpm-alpine AS production

WORKDIR /var/www

# Runtime system dependencies
RUN apk add --no-cache \
    libpng \
    libpq \
    oniguruma \
    libzip \
    freetype \
    libjpeg-turbo \
    libwebp \
    bash \
    nodejs \
    npm

# Copy PHP extensions compiled in builder stage
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/    /usr/local/etc/php/conf.d/

# Copy application
COPY --from=builder --chown=www-data:www-data /var/www /var/www

# Copy entrypoint
COPY --chown=www-data:www-data docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Remove user/group from www.conf to suppress FPM warnings
RUN sed -i 's/^user =/;user =/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/^group =/;group =/' /usr/local/etc/php-fpm.d/www.conf

USER www-data

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
