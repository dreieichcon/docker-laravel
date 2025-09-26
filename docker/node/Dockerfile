FROM node:lts AS base

WORKDIR /var/www

FROM base AS dependencies

COPY src/. .

RUN npm install

COPY docker/node/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 5173

ENTRYPOINT ["/entrypoint.sh"]