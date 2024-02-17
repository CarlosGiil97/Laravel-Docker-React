FROM php:8.2-apache
RUN a2enmod rewrite
WORKDIR /var/www
RUN apt-get update -y && apt-get install -y \
    libpq-dev \
    git\
    unzip zip \
    libzip-dev\
    zlib1g-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libicu-dev \
    libpng-dev 


# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN docker-php-ext-install gettext intl pdo_mysql gd
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd