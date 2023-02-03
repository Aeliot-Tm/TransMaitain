FROM php:7.4-cli
RUN apt-get --allow-releaseinfo-change update && apt-get install -y \
        libxml2-dev \
        libzip-dev \
        unzip  \
    && docker-php-ext-install -j$(nproc) xml \
    && docker-php-ext-install -j$(nproc) zip

# xDebug
ARG PHP_XDEBUG_PORT
RUN  pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=coverage,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=\"host.docker.internal\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=\${PHP_XDEBUG_PORT}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Memory limit
RUN echo "memory_limit = 1G" >> /usr/local/etc/php/php.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename composer --install-dir=/bin \
    && php -r "unlink('composer-setup.php');" \

WORKDIR /srv/app

COPY bin src tests translations .env .php-cs-fixer.dist.php composer.* phpunit.xml.dist ./

RUN composer install

RUN usermod -u 1000 www-data
