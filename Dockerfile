
# Stage 1 — PHP Dependencies

FROM php:8.2-fpm-alpine AS vendor

RUN apk add --no-cache git unzip libpng-dev libzip-dev icu-dev oniguruma-dev \
    && docker-php-ext-install pdo pdo_mysql gd zip intl


# Install Composer manually
RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer    

WORKDIR /app

# Copy composer files first
COPY composer.json composer.lock ./

# Install dependencies without triggering Laravel scripts
RUN composer install  --no-interaction --prefer-dist --optimize-autoloader  --no-scripts

#  Disable NunoMaduro\Collision provider automatically if still present
# RUN sed -i "/NunoMaduro\\\\Collision/d" config/app.php || true

# Copy app files
COPY . .

# Generate optimized autoload files safely
RUN composer dump-autoload --optimize --no-scripts





# Stage 2 — Node / Frontend

FROM node:20-alpine AS frontend

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build || echo "Skipping Vite build..."


# Stage 3 — Final Runtime Image

FROM php:8.2-fpm-alpine

# Install runtime dependencies + PHP extension dependencies
RUN apk add --no-cache nginx supervisor bash netcat-openbsd \
    libpng libpng-dev libjpeg-turbo libjpeg-turbo-dev freetype freetype-dev \
    libzip libzip-dev icu icu-dev oniguruma oniguruma-dev zlib zlib-dev \
    && docker-php-ext-install pdo pdo_mysql gd zip intl mbstring \
    && apk del libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev icu-dev oniguruma-dev zlib-dev

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy PHP extensions and configs from vendor stage

COPY --from=vendor /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=vendor /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Copy built vendor + frontend assets
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=frontend /app/public/build /var/www/html/public/build

# Copy configs
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

# Permissions
RUN chmod +x /entrypoint.sh 

RUN mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/framework/cache/data \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache



# Expose HTTP port
EXPOSE 80

# Start entrypoint (handles artisan setup + supervisor)
ENTRYPOINT ["/entrypoint.sh"]
