FROM php:8.4-fpm

WORKDIR /var/www

RUN apt -y update \
    && apt install -y --no-install-recommends \
    sudo \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libzip-dev \
    zip \
    unzip \
    openssl \
    sqlite3 \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    zip \
    curl \
    intl \
    gd \
    bcmath \
    mbstring \
    dom \
    pdo_mysql \
    sockets

RUN docker-php-ext-enable \
    sockets

ENV PHP_MEMORY_LIMIT=1024M

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY src/composer.json /var/www/

COPY docker/api/entrypoint.sh /

ARG DOCKER_USER=user
ARG DOCKER_USER_UID=1000

USER root

RUN useradd \
    --uid $DOCKER_USER_UID \
    --groups=www-data,root,sudo \
    --create-home \
    --home-dir=/home/${DOCKER_USER} \
    --shell=/bin/bash \
    ${DOCKER_USER}

RUN echo "${DOCKER_USER} ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

RUN chown -R $DOCKER_USER:$DOCKER_USER /var/www

USER $DOCKER_USER

VOLUME /var/www

EXPOSE 80

CMD ["/entrypoint.sh"]