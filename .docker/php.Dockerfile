FROM php:8.4-cli-alpine

# Argumentos para usuário
ARG user=application
ARG uid=1000

# Instala dependências do sistema e ferramentas necessárias
RUN apk add --update linux-headers --no-cache \
    bash \
    zip \
    unzip \
    shadow \
    autoconf \
    gcc \
    g++ \
    make \
    libzip-dev \
    oniguruma-dev \
    # && docker-php-ext-install pdo_mysql mbstring zip opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Remove cache apk para manter imagem leve
RUN rm -rf /var/cache/apk/*

# Instala Composer (copia do container oficial)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria usuário para rodar comandos (Composer, Artisan etc)
RUN useradd -u $uid -m $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

WORKDIR /var/www

USER $user

CMD [ "tail", "-f", "/dev/null" ]
