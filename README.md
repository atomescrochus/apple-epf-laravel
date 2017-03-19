# Integrate Apple's EPF in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/atomescrochus/apple-epf-laravel/master.svg?style=flat-square)](https://travis-ci.org/atomescrochus/apple-epf-laravel)

*Work in progress, not usable in production.*

This package will ultimately provides models and other tools to use Apple's Enterprise Partner Feed (EPF) in Laravel.

**This package do not provides EPF data, you will still have to download your own files.**

## Noteworthy notes to note

## The EPF files are HUGE

I'm am curently working (on `develop`) on a console command that will download and import the files directly from Apple's Enterprise Partner Feed servers to yours, then into your database. You *will* need a lot of disk space, this is not a process for 5$ (or less!) VPSs! For example:

In march 2017, I used the tool to download all of the file required for a "full" import of the database. I created a [20$ Digital Ocean droplet](https://m.do.co/c/025d0df24a5a), who comes with a pretty seedy 1Gbps network in. The total size of the download at the moment was approximately 30gb and it took 16 minutes 11 seconds. Make your speed is good, or be patient!

## Something is missing

- There is curently no models for the table `video_translation`: I could not successfully import it locally (yet), so there is no way for me to work with it, hence try to make a model for it. If anyone can help with that, a PR would be very welcomed!

## Installation

Important: The packages requires `wget` to be installed on your system.

You can install the package via composer:

```bash
composer require atomescrochus/apple-epf-laravel
```

You will have to publish the configuration files:
```bash
php artisan vendor:publish --provider="Atomescrochus\EPF\EPFServiceProvider" --tag="config"
```

You are also required to put your EPF login credentials in your .env files:

```
EPF_USER_ID=12345678
EPF_PASSWORD=abcdefg12345678
```

### Provider

Then add the ServiceProvider to your `config/app.php` file:

```php
'providers' => [
    ...

    Atomescrochus\EPF\EPFServiceProvider::class

    ....
]
```

## Usage

In my opinion, it is easier to keep the EPF database separate from your Laravel app. Now, you'll still need to configure Laravel for that different connection. You can do this by adding an additionnal connection to the relevant array in your `config/database.php` file like so:

```php
<?php // File: /config/database.php

'connections' => [

    // [...]

    'apple-epf' => [ // this is your EPF database connection, where you imported EPF
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'apple_epf',
        'username'  => 'admin',
        'password'  => 'secret',
        'charset'   => 'utf8',
        'collation' => 'utf8mb4_general_ci',
        'prefix'    => '',
        'strict'    => false,
        'engine'    => null,
    ],

],
```

**NOTE: this package's models will be looking for the connection with the name "apple-epf", do not change it.**

```php
// base usage of class.
$epf = new Atomescrochus\EPF();
echo $epf->echoPhrase("I'm alive!");
```

## Testing

```bash
$ composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/atomescrochus/apple-epf-laravel/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
