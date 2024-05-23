FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libjpeg-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libmemcached-dev \
    zlib1g-dev \
    libssl-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libmemcached-dev \
    pkg-config \
    zlib1g-dev \
    libzstd-dev \
    default-mysql-client \
    memcached \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install redis memcached \
    && docker-php-ext-enable redis memcached

RUN docker-php-ext-install mysqli pdo_mysql mbstring
RUN mkdir -p /var/www/.composer && \
    chown -R www-data:www-data /var/www/.composer
# Copy Composer binary
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY --chown=www-data:www-data . /var/www/html

# Switch to non-root user
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
