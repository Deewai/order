<?php
CONST api_prefix = '';

CONST api_key = 'AIzaSyD39RHtfY6sHMQBOkw1EUAmxH5VdEgaF7k';
define("__SERVER", $_ENV['MYSQL_PORT_3306_TCP_ADDR']);
define("__USER", "root");
define("__PASS", $_ENV['MYSQL_ENV_MYSQL_ROOT_PASSWORD']);
define("__DBNAME", $_ENV['MYSQL_ENV_MYSQL_ROOT_DATABASE']);
putenv('GOOGLE_APPLICATION_CREDENTIALS=./../ordertest_googleapi.json');

?>