# Integrate Apple's EPF in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/atomescrochus/apple-epf-laravel/master.svg?style=flat-square)](https://travis-ci.org/atomescrochus/apple-epf-laravel)

*Work in progress, not usable in production.*

This package will ultimately provides models and other tools to use Apple's Enterprise Partner Feed (EPF) in Laravel.

**This package do not provides EPF data, you will still have to download your own files.**

## Noteworthy notes to note

### Things that still needs attention

There is no defined relationship on the models. This is on the todo list, but if anyone wants to contribute, the [schema can be found here](https://affiliate.itunes.apple.com/resources/documentation/itunes-enterprise-partner-feed/), PRs are welcomed! ;-)

## Installation

Curently, the package only provides model. You can autoload them like any others.

## And add a new connection to the database array

You *have to* add another connection to your `config/database.php` file, this package will be looking for it. You could of course use the same credential as your main database, but to my experience, since EPF database is pretty huge, it's a good idea to keep things separate, it just make things easier.

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

Autoload the models.

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/atomescrochus/apple-epf-laravel/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
