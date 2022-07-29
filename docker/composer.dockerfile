FROM composer:2

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN docker-php-ext-install exif

RUN addgroup -g ${GID} --system tim
RUN adduser -G tim --system -D -s /bin/sh -u ${UID} tim

WORKDIR /var/www/html