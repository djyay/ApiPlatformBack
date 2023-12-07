# Utilisez l'image de base PHP avec la version PHP souhaitée
FROM php:8.1-fpm-buster

# Changer les sources APT pour Debian Buster
RUN echo "deb http://deb.debian.org/debian/ buster main" > /etc/apt/sources.list \
    && echo "deb-src http://deb.debian.org/debian/ buster main" >> /etc/apt/sources.list \
    && echo "deb http://security.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list \
    && echo "deb-src http://security.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list \
    && echo "deb http://deb.debian.org/debian/ buster-updates main" >> /etc/apt/sources.list \
    && echo "deb-src http://deb.debian.org/debian/ buster-updates main" >> /etc/apt/sources.list

# Installez les packages et les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    vim \
    curl \
    apache2 \
    debconf \
    subversion \
    git \
    apt-transport-https \
    apt-utils \
    build-essential \
    locales \
    acl \
    mailutils \
    wget \
    nodejs \
    zip \
    unzip \
    gnupg \
    gnupg1 \
    gnupg2 \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxslt-dev \
    libonig-dev \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    libmagickwand-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd xsl pdo pdo_pgsql pgsql intl zip pdo_mysql mysqli \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && echo 'en_US.UTF-8 UTF-8' > /etc/locale.gen \
    && echo 'fr_FR.UTF-8 UTF-8' >> /etc/locale.gen \
    && locale-gen en_US.UTF-8 fr_FR.UTF-8

# Installez Composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer
# Nettoyer le cache APT et les listes de paquets inutiles pour garder le docker image clean
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Configuration PHP
COPY php.ini /usr/local/etc/php/php.ini
COPY upload.ini /usr/local/etc/php/conf.d/uploads.ini
#COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Define working directory.
WORKDIR /home/wwwroot/

# Exposez le port sur lequel fpm écoutera, par défaut 9000
EXPOSE 9000

# Utilisez la commande php-fpm pour démarrer PHP FastCGI Process Manager
CMD ["php-fpm"]
