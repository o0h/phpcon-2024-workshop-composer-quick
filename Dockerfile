FROM composer:2.8.3

# php-ext
RUN curl -L --output /usr/local/bin/pie https://github.com/php/pie/releases/download/0.2.0/pie.phar \
    && chmod +x /usr/local/bin/pie
RUN apk add --no-cache linux-headers autoconf build-base
RUN pie install xdebug/xdebug:3.4.0
RUN docker-php-ext-enable xdebug

# terminal tools
RUN apk add bash vim
