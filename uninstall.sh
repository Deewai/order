#!/bin/bash
>&2 echo "Stopping containers...."
docker-compose stop;

>&2 echo "Removing containers...."
docker-compose rm;

