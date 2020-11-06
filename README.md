# hotel-booking

## Commandes symfony

### Create project
symfony new --version=4.4 --full <nom du projet>

### Composer
composer require --dev doctrine/doctrine-fixtures-bundle
composer require --dev fzaninotto/faker

### Controller
php bin/console make:controller DefaultController

### Make user
php bin/console make:user

### Migrations
php bin/console make:migration
php bin/console doctrine:migration:migrate

### Fixtures
php bin/console make:fixtures
php bin/console doctrine:fixtures:load

###Make Auth
php bin/console make:auth
