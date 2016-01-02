keep
====

To set up the project
- run: composer install
- create empty database `keep`
- run: php app/console doctrine:migrations:migrate
- run: php app/console doctrine:fixtures:load

To run tests
- create empty database `keep_test`
- run: php app/console doctrine:migrations:migrate --env=test
- run: phpunit -c app