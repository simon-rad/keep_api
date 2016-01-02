[![Build Status](https://travis-ci.org/semen4eg/keep.svg?branch=master)](https://travis-ci.org/semen4eg/keep)
====

To set up the project
- run: composer install
- run: php app/console doctrine:database:create
- run: php app/console doctrine:migrations:migrate
- run: php app/console doctrine:fixtures:load

To run tests
- run: php app/console doctrine:database:create --env=test
- run: php app/console doctrine:migrations:migrate --env=test
- run: phpunit -c app
