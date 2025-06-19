#!/bin/bash

set -x
set -e

echo "installing composer vendors"
docker run --rm -v ./:/tmp/build -t wolxxxy/php71 /bin/bash -c "cd /tmp/build && composer install"
echo "running unit tests"
docker run --rm -v ./:/tmp/build -t wolxxxy/php71 /bin/bash -c "cd /tmp/build && ./vendor/bin/phpunit"

exit 0