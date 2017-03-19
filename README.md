# Integrate Apple's EPF in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/atomescrochus/apple-epf-laravel/master.svg?style=flat-square)](https://travis-ci.org/atomescrochus/apple-epf-laravel)

This will ultimately provides models and other tools to use Apple's Enterprise Partner Feed (EPF) in Laravel. **This package do not provides EPF data, you still have to bring your own files.** *Work in progress, not usable in production.*

## Installation

Important: The packages requires `wget` to be installed on your system, as it uses it to fetch the EPF files.

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

## Notes

There is curently no models for the table `video_translation`: I could not successfully import it locally (yet), so there is no way for me to work with it, hence try to make a model for it. If anyone can help with that, a PR would be very welcomed!

## Testing

```bash
$ composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/atomescrochus/apple-epf-laravel/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
