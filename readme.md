Swagger
======

Swagger for Laravel

This package combines [swagger-php](https://github.com/zircote/swagger-php) and [swagger-ui](https://github.com/wordnik/swagger-ui) into one Laravel-friendly package.

When you run your app in debug mode, Swagger will scan your Laravel app folder,
generate swagger json files and deposit them to the docs-dir folder (default is "docs").
Files are then served by swagger-ui under the api-docs director.

## Installation

```
composer require latrell/swagger dev-master
```

Update your packages with ```composer update``` or install with ```composer install```.


## Usage

To use the Swagger Service Provider, you must register the provider when bootstrapping your Laravel application.
There are essentially two ways to do this.

Find the `providers` key in `app/config/app.php` and register the Smarty Service Provider.

```php
    'providers' => array(
        // ...
        'Latrell\Swagger\SwaggerServiceProvider',
    )
```

Run php artisan `swagger:install` to push swagger-ui to your public folder and publish the config file.

OR

Then publish the public files with `php artisan asset:publish latrell/swagger` to push swagger-ui to your public folder.

Then publish the config file with `php artisan config:publish latrell/swagger`. This will add the file `app/config/packages/latrell/swagger/config.php`.
This config file is the primary way you interact with Swagger.

## Documentation

[http://zircote.com/swagger-php](http://zircote.com/swagger-php)
