# order

# usage

The project assumes docker and docker-compose have been installed on the local machine.

The api makes use of HERE maps routing api which makes use of an app id and app code.

The app id and app code should be set before running the start.sh script.

The app id and app code are conained in ./api/config/config.php.

The constant app_id should be set to your app id and the app_code should be set to your app code.


After this the start.sh can be executed.

After a successful startup a message "Application running at port 8080...." should be displayed in the console.