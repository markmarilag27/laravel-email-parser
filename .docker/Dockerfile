FROM ubuntu:22.04

LABEL maintainer="Mark Marilag <mark.marilag27@gmail.com>"

ARG NODE_VERSION=20
ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
    apt-get install -y \
    gnupg \
    gosu \
    curl \
    ca-certificates \
    zip \
    unzip \
    supervisor \
    sqlite3 \
    cron \
    libcap2-bin \
    libpng-dev \
    python2 \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    dnsutils && \
    curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /usr/share/keyrings/ppa_ondrej_php.gpg > /dev/null && \
    echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list

RUN apt-get update && apt-get install -y \
    nginx \
    php8.3-cli \
    php8.3-dev \
    php8.3-fpm \
    php8.3-gd \
    php8.3-curl \
    php8.3-imap \
    php8.3-sqlite3 \
    php8.3-mysql \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-zip \
    php8.3-bcmath \
    php8.3-soap \
    php8.3-intl \
    php8.3-readline \
    php8.3-ldap \
    php8.3-msgpack \
    php8.3-igbinary \
    php8.3-redis \
    php8.3-pcov \
    php8.3-xdebug \
    && curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /usr/share/keyrings/yarn.gpg >/dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y yarn \
    && apt-get install -y mysql-client

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get -y autoremove && \
    apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN groupadd --force -g 1000 laravel
RUN useradd -ms /bin/bash --no-user-group -g 1000 -u 1000 laravel

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY fpm-pool.conf /etc/php/8.3/fpm/pool.d/www.conf
COPY php.ini /etc/php/8.3/fpm/conf.d/99-php.ini

RUN mkdir -p /var/www/html && \
    mkdir -p /var/log/php && \
    mkdir -p /var/log/supervisor && \
    mkdir -p /tmp/laravel/storage/framework/views

RUN chown -R laravel:laravel /var/www/html && \
    chown -R laravel:laravel /run && \
    chown -R laravel:laravel /var/lib/nginx && \
    chown -R laravel:laravel /var/log/nginx && \
    chown -R laravel:laravel /var/log/php && \
    chown -R laravel:laravel /tmp/laravel/storage/framework/views

WORKDIR /var/www/html

EXPOSE 80

CMD [ "/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf" ]

