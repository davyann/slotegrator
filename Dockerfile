FROM php:8.3-fpm-alpine

# php configuration
COPY ./docker/development/php/php.ini /usr/local/etc/php/php.ini

# Основные зависимости
RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install pdo pdo_mysql && \
    docker-php-ext-install pdo pdo_mysql && \
    apk update && apk add bash unzip git


RUN set -ex \
  && apk --no-cache add \
    postgresql-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_pgsql zip


# Xdebug
RUN apk --no-cache add linux-headers pcre-dev ${PHPIZE_DEPS} \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && apk del linux-headers pcre-dev ${PHPIZE_DEPS}

RUN  echo "xdebug.idekey = "PHPSTORM"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.remote_handler ="dbgp"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.discover_client_host=false" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ENV PHP_IDE_CONFIG="serverName=Docker"

# Install PHP APC User Cache
RUN apk --no-cache add linux-headers pcre-dev ${PHPIZE_DEPS} \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && pecl clear-cache \
    && apk del linux-headers pcre-dev ${PHPIZE_DEPS}


COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

CMD php-fpm;
