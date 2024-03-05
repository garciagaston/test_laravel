# TEST LARAVEL

## INSTALLATION

1. install composer
    ```bash
    composer install
    ```

2. rename .env.example to .env file

3. add mysql configuration to .env file

4. run migrations
    ```bash
    php artisan migrate
    ```

5. seed DB
    ```bash
    php artisan db:seed
    ```

refresh migrations and seed
    ```bash
    php artisan migrate:refresh --seed
    ```

6. Serve Laravel
    ```bash
    php artisan serve
    ```

7. Run Laravel Pint code validations

    ```bash
    ./vendor/bin/pint
    ```
8. Run Laravel PHP Stan code validations
    ```bash
    ./vendor/bin/phpstan analyse ./app
    ```

## COMMANDS

Import Entities
Run the following command to import Entities from https://api.publicapis.org/entries

    php artisan entities:import


## UNIT TESTS

Run Unit Tests
Command to run unit test

    php artisan test

## API DOCUMENTATION
Get paginated categories:

    GET {SITE_URL}/api/{category ID}
    HEADER {
        Accept:application/json
    }

## IMPORTANT FILES

    app/Http/Controllers/EntityController.php
    app/Console/Commands/EntitiesImport.php
    app/Http/Resources
    app/Http/Services
    app/Models
    config/entities.php
    database/factories
    database/migrations
    database/seeders
    routes/api.php
    tests/Unit
    composer.json
