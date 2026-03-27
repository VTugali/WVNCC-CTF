#!/bin/bash
docker-php-ext-install mysqli
apt-get update && apt-get install -y libcurl4-openssl-dev
docker-php-ext-install curl
apachectl restart
