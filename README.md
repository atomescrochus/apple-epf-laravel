# Integrate Apple's EPF in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/atomescrochus/apple-epf-laravel/master.svg?style=flat-square)](https://travis-ci.org/atomescrochus/apple-epf-laravel)

*Work in progress. While I do not recommend using in production yet, things should be working as advertised.*

This package provides models and other tools to use Apple's Enterprise Partner Feed (EPF) in Laravel.

**This package do not provides EPF data, you will still have to download your own files.**

## Installation

You can install the package via composer:

```bash
composer require atomescrochus/apple-epf-laravel
```

Then add the ServiceProvider to your `config/app.php` file:

```php
'providers' => [
    ...

    Atomescrochus\EPF\EPFServiceProvider::class

    ....
]
```

You will *have to* add another connection to your `config/database.php` file, this package will be looking for it. You can of course use the same credential as your main database, but to my experience, since EPF database is pretty huge, it's a good idea to keep things separate, it just make things easier.

Below, you'll find the template of the connection to add. You can see we're using the `.env` file to set the connection infos, if necessary. You will have to add those variables to your own `.env`, don't forget!

**This package's models will be looking for the connection with the name "apple-epf", do not change the connection name ot you will break things!**

```php
<?php // File: /config/database.php

'connections' => [

    // [...]

    'apple-epf' => [
        'driver' => 'mysql',
        'host' => env('EPF_DB_HOST', '127.0.0.1'),
        'port' => env('EPF_DB_PORT', '3306'),
        'database' => env('EPF_DB_DATABASE', 'forge'),
        'username' => env('EPF_DB_USERNAME', 'forge'),
        'password' => env('EPF_DB_PASSWORD', ''),
        'unix_socket' => env('EPF_DB_SOCKET', ''),
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => env('EPF_DB_PREFIX', ''),
        'strict' => true,
        'engine' => null,
    ],

],
```

## Usage

If you want to only use the provided models to your own database, just autoload them like any other models.

If you don't have your data yet, you can, if you provided your credentials to access the EPF feed to the `.env` file, use the following artisan commands:

- `php artisan epf:download` will help your download the files;
- `php artisan epf:extract` will extract the downloaded files;
- `php artisan epf:import` will import the data to database using the `apple-epf` connection, using the provided models.

**Be careful, you can use the `all` option when prompted while using the artisan command, but it's not advisable. The archives are huge, extracted files are huge, and the data in the database will be taking a lot of space also.** You should really try to import in parts as much as you can, so you can remove unecessary files to free up some space so you can finish the rest of the imports...

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/atomescrochus/apple-epf-laravel/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
