RUN docker-php-ext-install mysqli pdo pdo_mysql

docker exec php /bin/sh -c '../order/api/vendor/bin/phpunit --bootstrap ../order/tests/bootstrap.php ../order/tests'