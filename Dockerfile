FROM dunglas/frankenphp

RUN install-php-extensions mysqli

COPY . /app

ENV FRANKENPHP_CONFIG="worker /app/index.php"