# Integrate Apple's EPF in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/atomescrochus/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/atomescrochus/apple-epf-laravel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/atomescrochus/apple-epf-laravel/master.svg?style=flat-square)](https://travis-ci.org/atomescrochus/apple-epf-laravel)

This will ultimately provides models and other tools to use Apple's Enterprise Partner Feed (EPF) in Laravel. **This package do not provides EPF data, you still have to bring your own files.** *Work in progress, not usable in production.*

## Installation

You can install the package via composer:

```bash
composer require atomescrochus/apple-epf-laravel
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

```php
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
