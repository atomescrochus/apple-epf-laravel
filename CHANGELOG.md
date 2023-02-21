# Changelog

## 0.4 - 2023-02-21
Big rewrite and upgrade of the original package. Keeping the version sub 1.0 until everything is fully tested and functional.

### General
- PHP 8 support
- Laravel 8 support and usage of Laravel's support package
- Code cleanup and documentation

### Apple EPF v5 support
- Removed any Mix or iMix models (v5)
- Changed the structure of crawling the files (v4)

### Commands
- Added parameters to all 3 commands to be able skip the question/answer. The original question/answer flow is still available
- Commands now queue jobs instead of executing everything inside the command

### Configuration
- Added a configurable database connection, still uses "apple-epf" as the default one
- Added a configurable array of included models:
  - Defines what gets downloaded or imported during the whole process
  - Defines what migrations gets published to only have the tables you need in your database
- Added the possibility to enable chaining jobs automatically (download -> extract -> import)
- Added a configurable queue for the jobs

### Models
- Replaced the database dynamic creation by dynamic publishable migrations, dynamic creation is nice but the database is at the mercy of what the files contain, which is a security risk
- Separated the models by group (itunes, match, popularity and pricing) for readability
- Added composite primary keys support, as multiple EPF feeds use them and the import would throw an exception with only one primary key

## 0.3.1 - 2017-10-09
### Fix
- Auto-discovery

## 0.3.0 - 2017-10-09
- Added support for Laravel 5.5 package autodiscovery.

## 0.2.3 (2017-04-03)
- Still working on relationships.

## 0.2.2 (2017-03-24)
- Small work on song model relationship.

## 0.2.1 (2017-03-24)
- Correctly converts EPF's files date time to compatible format (replaces spaces by dashes);

## 0.2.0 (2017-03-24)
- Added `epf:download`, `epf:extract` and `epf:import` to help manage EPF data from Apple's servers to yours.

## 0.1.0 (2017-03-23)
- All models are presents.

## 0.0.1 (2017-03-18)
- Base skeleton for the package, based on appstract/php-skeleton