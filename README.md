# Integrate Apple's EPF in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/atomescrochus/apple-epf-laravel/master.svg?style=flat-square)](https://travis-ci.org/atomescrochus/apple-epf-laravel)

*Work in progress, not usable in production.*

This package will ultimately provides models and other tools to use Apple's Enterprise Partner Feed (EPF) in Laravel.

**This package do not provides EPF data, you will still have to download your own files.**

## Noteworthy notes to note

### The EPF files are HUGE

I'm am curently working (on `develop`) on a console command that will download and import the files directly from Apple's Enterprise Partner Feed servers to yours, then ingest into your database. You *will* need a lot of disk space, this is not a process for 5$ (or less!) VPSs! For example:

In march 2017, I used the tool to download all of the file required for a "full" import of the database. I created a [20$ Digital Ocean droplet](https://m.do.co/c/025d0df24a5a), who comes with a pretty seedy 1Gbps network in. The total size of the download at the moment was approximately 30gb and it took 16 minutes 11 seconds. Make your speed is good, or be patient!

### Things that still needs attention

There is no defined relationship on the models. This is on the todo list, but if anyone wants to contribute, the [schema can be found here](https://affiliate.itunes.apple.com/resources/documentation/itunes-enterprise-partner-feed/), PRs are welcomed! ;-)

## Installation

Important: The packages requires `wget` to be installed on your system (TODO: move that to Guzzle!).

You can install the package via composer:

```bash
composer require atomescrochus/apple-epf-laravel
```

Add the ServiceProvider to your `config/app.php` file:

```php
'providers' => [
    ...

    Atomescrochus\EPF\EPFServiceProvider::class,

    ....
]
```

You will then have to publish the configuration files:
```bash
php artisan vendor:publish --provider="Atomescrochus\EPF\EPFServiceProvider" --tag="config"
```

You can see some basic configuration right in the published file.

### And add a new connection to the database array

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

### .env file
You are also required to put your EPF login credentials in your .env files as below:

```
EPF_USER_ID=12345678
EPF_PASSWORD=abcdefg12345678
```

Also, as stated earlier, you will have to add the database informations in here if you need to change the default values.

## Usage

Coming soon.

## Testing

```bash
$ composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/atomescrochus/apple-epf-laravel/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
