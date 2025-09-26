FROM php:8.2-fpm AS base

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip && \
    apt-get clean && rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

FROM base AS dependencies
ARG PROJECT_NAME

COPY src/. .

# Copy the environment file during build
COPY src/.env.example ./.env

RUN sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" ./.env && \
    sed -i "s/DB_HOST=.*/DB_HOST=${PROJECT_NAME}-db/" ./.env && \
    sed -i "s/DB_PORT=.*/DB_PORT=3306/" ./.env && \
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=docker_db/" ./.env && \
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=docker_db/" ./.env && \
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=docker_db/" ./.env && \
    sed -i "s/APP_NAME=.*/APP_NAME=${PROJECT_NAME}/" ./.env && \
    sed -i "s|APP_URL=.*|APP_URL=https://${PROJECT_NAME}.test|" ./.env

COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
