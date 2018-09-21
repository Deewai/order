#!/bin/bash
>&2 echo "Building all containers...."
docker-compose up -d;
>&2 echo "Installing pdo_mysql...."
docker exec php /bin/sh -c 'docker-php-ext-install mysqli pdo pdo_mysql';
>&2 echo "Restarting php container...."
docker-compose stop php;
docker-compose start php;
>&2 echo "Installing database schema...."
docker cp ./api/config/schema.sql mysql:/schema.sql;
docker exec mysql /bin/sh -c 'mysql -P 3306 --protocol=tcp -u root -pmorerin </schema.sql';
>&2 echo "Running composer install..."
docker exec php /bin/sh -c 'cd ../order/api;php composer.phar install;'
>&2 echo "Running tests..."
docker exec php /bin/sh -c '../order/api/vendor/bin/phpunit --bootstrap ../order/tests/bootstrap.php ../order/tests'
>&2 echo "Application running at port 3128...."