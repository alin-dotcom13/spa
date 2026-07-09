FROM dunglas/frankenphp
RUN install-php-extensions mysqli
# Menyalin semua file ke lokasi standar
COPY . /var/www/html
# Mengarahkan konfigurasi ke folder baru
ENV FRANKENPHP_CONFIG="worker /var/www/html/index.php"