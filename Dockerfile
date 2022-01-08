FROM php:7.4-fpm


# Copy composer.lock and composer.json
COPY ./src/composer.lock ./src/composer.json /var/www/
COPY ./docker-entry.sh /
RUN chmod +x /docker-entry.sh

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    nginx \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql exif pcntl zip
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory
COPY ./src /var/www/

COPY ./configuration/nginx/conf.d/ /etc/nginx/conf.d/
RUN ls /etc/nginx/conf.d

COPY ./configuration/php/local.ini /usr/local/etc/php/conf.d/local.ini
RUN ls /usr/local/etc/php/conf.d
RUN cat /usr/local/etc/php/conf.d/local.ini

RUN rm -rf /etc/nginx/sites-enabled
RUN mkdir -p /etc/nginx/sites-enabled

RUN chown -R www-data:www-data /var/www/
RUN chmod -R 777 /var/www/storage
RUN composer install

ARG APP_NAME=${APP_NAME}
ARG APP_KEY=${APP_KEY}
ARG APP_ENV=${APP_ENV}
ARG APP_DEBUG=${APP_DEBUG}

ARG CACHE_DRIVER=${CACHE_DRIVER}
ARG QUEUE_CONNECTION=${QUEUE_CONNECTION}
ARG SESSION_DRIVER=${SESSION_DRIVER}

ARG DB_CONNECTION=${DB_CONNECTION}
ARG DB_HOST=${DB_HOST}
ARG DB_PORT=${DB_PORT}
ARG DB_DATABASE=${DB_DATABASE}
ARG DB_USERNAME=${DB_USERNAME}
ARG DB_PASSWORD=${DB_PASSWORD}

ARG PAPERTRAIL_URL=${PAPERTRAIL_URL}
ARG PAPERTRAIL_PORT=${PAPERTRAIL_PORT}

ARG FILESYSTEM_DRIVER=${FILESYSTEM_DRIVER}

# Expose port 80 and start php-fpm server
EXPOSE 80
CMD ["/docker-entry.sh"]
