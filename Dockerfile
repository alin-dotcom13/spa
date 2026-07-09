FROM dunglas/frankenphp
RUN install-php-extensions mysqli
COPY . /var/www/html
ENV FRANKENPHP_CONFIG="worker /var/www/html/test.php"