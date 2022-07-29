FROM php:8.1-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

RUN addgroup -g ${GID} --system paynetics
RUN adduser -G paynetics --system -D -s /bin/sh -u ${UID} paynetics

RUN sed -i "s/user = www-data/user = paynetics/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = paynetics/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN apk add libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]