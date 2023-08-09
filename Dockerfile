FROM aguedomeza/centos7:php-apache-openssl
WORKDIR /var/www/html
COPY *.json ./
COPY artisan ./
COPY . .
RUN composer install
#ENV COMPOSER_ALLOW_SUPERUSER=1
#RUN composer require league/flysystem
#RUN composer require league/flysystem-ftp
RUN cp .env.example .env
RUN php artisan key:generate
RUN chown -R 775 public
RUN chown -R apache.apache public
RUN chown -R $USER:apache public
RUN chmod -R 775 storage
RUN chmod -R ugo+rw storage
EXPOSE 80
CMD ["/usr/sbin/httpd","-D","FOREGROUND"]