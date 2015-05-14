Swagger
======

For Laravel 4, please use the [0.3 branch](https://github.com/Latrell/Swagger/releases/tag/0.3)!

Swagger for Laravel 5

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

Find the `providers` key in `config/app.php` and register the Swagger Service Provider.

```php
    'providers' => [
        // ...
        'Latrell\Swagger\SwaggerServiceProvider',
    ]
```

Run `php artisan vendor:publish` to push swagger-ui to your public folder and publish the config file.

Config file `config/latrell-swagger.php` is the primary way you interact with Swagger.

## Example

* [Demo](http://petstore.swagger.wordnik.com)
* [Documentation](http://zircote.com/swagger-php)

