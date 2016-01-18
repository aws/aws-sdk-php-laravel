# CHANGELOG

## 3.1.0 - 2016-01-17

* Added support for Lumen.

## 3.0.3 - 2015-09-18

* Added support for configuring credentials with environmental variables, a ini
  file at `~/.aws/credentials`, or with Ec2 instance profiles instead of
  requiring their inclusion in the `aws.php` config file.

## 3.0.3 - 2015-08-10

* Removed usage of a dev dependency

## 3.0.1 - 2015-08-05

* Provide version information to SDK user agent

## 3.0.0 - 2015-06-10

* Service provider is now compatible with Laravel 5.1 and Version 3 of the AWS
  SDK for PHP.

## 2.0.1 - 2015-06-10

* Service provider is now compatible with Lumen

## 2.0.0 - 2015-03-12

* Updated the service provider to work with Laravel 5.

## 1.1.2 - 2015-02-13

* Added alias to support DI from container.

## 1.1.1 - 2014-05-12

* Updated default module config file to make it more compatible with environment
  credentials

## 1.1.0 - 2013-09-03

* Added package-level config that can be published with Artisan
* Updated config loading logic to support package-level config
* Updated config loading logic to support AWS SDK for PHP config files via the
  `config_file` key
* Updated code, tests, and the README to support the config refactoring
* This module is now following [semver](http://semver.org/)

## 1.0.4 - 2013-06-20

* Added support for the AWS facade
* Updated `composer.json` to require only specific components of Laravel
* Updated `composer.json` to require version 2.2+ of the AWS SDK for PHP

## 1.0.3 - 2013-04-25

* Update Composer dependencies to work with newer version of the AWS SDK for PHP
  and Laravel

## 1.0.2 - 2013-03-11

* Fixed an issue with config retrieval

## 1.0.1 - 2013-03-07

* Improved usage instructions in the README
* Fixed logic for retrieving Laravel version

## 1.0.0 - 2013-02-13

* Initial release.
