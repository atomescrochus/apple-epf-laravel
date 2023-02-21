# Integrate Apple's EPF in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appwapp/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/appwapp/apple-epf-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/appwapp/apple-epf-laravel.svg?style=flat-square)](https://packagist.org/packages/appwapp/apple-epf-laravel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

*Work in progress. While I do not recommend using in production yet, things should be working as advertised.*

This package provides models and other tools to use [Apple's Enterprise Partner Feed (EPF) v5](https://feeds.itunes.apple.com/feeds/epf/v5) in Laravel.

**This package do not provides EPF data, you will still have to download your own files with your partner account.**

## Installation

You can install the package via composer (not yet available):

```bash
composer require appwapp/apple-epf-laravel
```

Then you have to install the package' service provider, _unless you are running Laravel >=5.5_ (it'll use package auto-discovery) :

```php
'providers' => [
    // ...

    Appwapp\EPF\EPFServiceProvider::class

    // ...
]
```

The package requires the following in your `.env` file in order to download the Apple's EPF files:

```env
EPF_USER_ID=
EPF_PASSWORD=
```


To publish the configuration to your app, execute the following command:

```text
php artisan vendor:publish --tag=apple-epf-config
```

Then you should edit the configuration to only include the data you need. The Apple EPF data is **a lot**, we suggest only using what you need by commenting the models you don't need.

```php
    'included_models' => [
        Appwapp\EPF\Models\Itunes\Application::class,
        Appwapp\EPF\Models\Itunes\ApplicationDetail::class,
        Appwapp\EPF\Models\Itunes\ApplicationDeviceType::class,

        // ...
    ]
```

To publish the migrations to your app, execute this:

```text
php artisan vendor:publish --tag=apple-epf-migrations
```

**Important:** The migrations will be dynamicly filtered with your configuration of `included_models`, make sure your `config/apple-epf.php` is published and edited before publishing the migrations.

By default, you will have to add another connection to your `config/database.php` file called `apple-epf`, this package will be looking for it. You can of course use the same credential as your main database, but to my experience, since EPF database is pretty huge, it's a good idea to keep things separate, it just make things easier. If you want to use another database connection then `apple-epf`, you can configure it in the `config/apple-epf.php` file.

Below, you'll find the template of the connection to add. You can see we're using the `.env` file to set the connection infos, if necessary. You will have to add those variables to your own `.env`, don't forget!

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

- `php artisan epf:download` will help you download the files;
- `php artisan epf:extract` will extract the downloaded files;
- `php artisan epf:import` will import the data to database using the configured connection, using the provided models.

Each command will dispatch jobs, depending on your needs, you should edit your queue configuration and queue workers.

By default, every command will prompt for additional information for you to choose, but each command can also be run with parameters to be able to run them in a cron or programatically:
|command|parameter|description|
|-------|---------|-----------|
|`epf:download`|`--type`|the type of import, either `full`, or `incremental`|
||`--group`| the group of import, either `itunes`, `match`, `popularity` or `pricing`|
||`--skip-confirm`| skips the confirmation prompt|
||`--chain-jobs`| chain the next jobs after the download|
|`epf:extract`|`--type`|the type of import, either `full`, or `incremental`|
||`--group`| the group of import, either `itunes`, `match`, `popularity` or `pricing`|
||`--file`| the file you want to extract, either `all` or the file path you want to extract|
||`--skip-confirm`| skips the confirmation prompt|
||`--delete`| delete the archive after extraction|
|`epf:import`|`--type`|the type of import, either `full`, or `incremental`|
||`--group`| the group of import, either `itunes`, `match`, `popularity` or `pricing`|
||`--folder`| the folder name to import from, ex: `itunes20230115`|
||`--file`| the file you want to import, either `all` or the file you want to import|
||`--skip-confirm`| skips the confirmation prompt|
||`--delete`| deletes the file once imported|

**Be careful, you can use the `all` option while using the artisan commands, but it's not advisable. The archives are huge, extracted files are huge, and the data in the database will be taking a lot of space.** You should really try to import in parts as much as you can, so you can remove unecessary files to free up some space so you can finish the rest of the imports.

## Contributing

Feel free to contribute, we expect some standards to be used. See [contributing](CONTRIBUTING.md).

This package was forked from [atomescrochus/apple-epf-laravel](https://github.com/atomescrochus/apple-epf-laravel), thanks to the [original contributors](https://github.com/atomescrochus/apple-epf-laravel/graphs/contributors)!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
