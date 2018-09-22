# Order

# Usage

The project assumes docker and docker-compose have been installed on the local machine.

The api makes use of HERE maps routing api which makes use of an app id and app code.

The app id and app code should be set before running the start.sh script.

The app id and app code are conained in ./api/config/config.php.

The constant app_id should be set to your app id and the app_code should be set to your app code.


After this the start.sh can be executed.

After a successful startup a message "Application running at port 8080...." should be displayed in the console.


# Solution

The Solution makes use of 3 docker containers with a start.sh script is used to install and startup containers.

A container for php, one for mysql and one for nginx all setup with docker-compose

The rest api is contained in the api folder, the tests in the tests folder which makes use of phpunit.

## The api

The api consists of a config folder where all configuration and routing is done including the database schema,
a controller folder a model folder and a vendor folder with an index.php entry point for the aplication

## The tests
The test written takes the folder structure of the api