FROM dunglas/frankenphp:1.2-php8.3.11-alpine

# install bash
RUN apk add --no-cache bash

# use bash as default shell
SHELL ["/bin/bash", "-c"]

RUN install-php-extensions \
    pcntl \
    pdo_mysql

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && echo '' | pecl install redis \
    && docker-php-ext-enable redis.so

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
#RUN echo "extension=redis.so" >> "$PHP_INI_DIR/php.ini"

COPY . /app

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install

# Install GCP cli in root / directory
#RUN apk add --no-cache python3 curl

# Install the Google Cloud SDK
#RUN curl -sSL https://sdk.cloud.google.com | bash

# Move google-cloud-sdk to root directory
#RUN mv /root/google-cloud-sdk /google-cloud-sdk

# Update PATH environment variable
#ENV PATH $PATH:/google-cloud-sdk/bin

# migrate database
RUN php artisan migrate --force

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
