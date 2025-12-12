# Composer だけ取ってくるステージ
FROM composer:2 AS composer_stage

# PHP本体
FROM php:8.1-fpm

# ─ UID/GID をホストと合わせるための引数 ─
ARG UID=1000
ARG GID=1000

# 必要パッケージ & PHP拡張
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    zip \
  && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    intl \
    zip \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# ホストと同じ UID/GID のユーザーを作成
RUN groupadd -g ${GID} laravel \
  && useradd -m -u ${UID} -g ${GID} -s /bin/bash laravel

# Composer をコンテナにコピー
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ
WORKDIR /var/www

# /var/www を laravel ユーザーのものに
RUN chown -R laravel:laravel /var/www

# 以降は laravel ユーザーで実行
USER laravel
