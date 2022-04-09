FROM composer:2.3

ENV APP_HOME /usr/src/app/

WORKDIR $APP_HOME

COPY ./composer.json ./composer.lock $APP_HOME

RUN composer install

COPY ./ $APP_HOME
