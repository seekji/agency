FROM php:7.4.11-fpm

ARG project_dir=/var/www/public
ARG USER_ID=1000
ARG GUID=1000

RUN mkdir -p $project_dir && chown www-data:www-data /var/www

WORKDIR $project_dir

RUN apt-get update \
    && apt-get -y install nano curl mc strace htop zlib1g-dev libzip-dev libicu-dev libpq-dev git libmagickwand-dev rsync locales gettext-base libfreetype6-dev libpng-dev libjpeg-dev libonig-dev  \
    && pecl install imagick \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd \
    		--with-freetype=/usr/include/ \
    		--with-jpeg=/usr/include/ \
    && docker-php-ext-install zip xml bcmath mbstring pgsql pdo_pgsql intl opcache sockets gd \
    && docker-php-ext-enable imagick \
    && rm -r /var/lib/apt/lists/*

# Install APCu and APC backward compatibility
RUN pecl install apcu \
    && pecl install apcu_bc-1.0.3 \
    && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini \
    && docker-php-ext-enable apc --ini-name 20-docker-php-ext-apc.ini

RUN curl --silent --show-error https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY fpm/php.ini $PHP_INI_DIR/php.ini
COPY fpm/php-fpm.conf $PHP_INI_DIR/../php-fpm.d/www.conf

RUN usermod -u $USER_ID www-data && \
    groupmod -g $GUID www-data && \
    mkdir /var/www/.ssh/ && \
    echo "Host github.com\n\tStrictHostKeyChecking no\n" > /var/www/.ssh/config
