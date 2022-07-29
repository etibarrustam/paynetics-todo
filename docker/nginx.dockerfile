FROM nginx:stable-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN addgroup -g ${GID} --system paynetics
RUN adduser -G paynetics --system -D -s /bin/sh -u ${UID} paynetics
RUN sed -i "s/user  nginx/user paynetics/g" /etc/nginx/nginx.conf

ADD ./nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html