# AWS Service Provider for Laravel 5

[![@awsforphp on Twitter](http://img.shields.io/badge/twitter-%40awsforphp-blue.svg?style=flat)](https://twitter.com/awsforphp)
[![Build Status](https://img.shields.io/travis/aws/aws-sdk-php-laravel.svg)](https://travis-ci.org/aws/aws-sdk-php-laravel)
[![Latest Stable Version](https://img.shields.io/packagist/v/aws/aws-sdk-php-laravel.svg)](https://packagist.org/packages/aws/aws-sdk-php-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/aws/aws-sdk-php-laravel.svg)](https://packagist.org/packages/aws/aws-sdk-php-laravel)
[![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/aws/aws-sdk-php?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

A simple [Laravel 5](http://laravel.com/) service provider for making it easier to include the official [AWS SDK for PHP](https://github.com/aws/aws-sdk-php) into your Laravel application.

_(Looking for the Laravel 4 service provider? It's still available in the [1.0 branch](https://github.com/aws/aws-sdk-php-laravel/tree/1.0).)_

## Installation

The AWS Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`aws/aws-sdk-php-laravel` package in your project's `composer.json`.

```json
{
    "require": {
        "aws/aws-sdk-php-laravel": "~2.0"
    }
}
```

Then run a composer update
```sh
php composer.phar update
```

To use the AWS Service Provider, you must register the provider when bootstrapping your Laravel application.

Find the `providers` key in your `config/app.php` and register the AWS Service Provider.

```php
    'providers' => array(
        // ...
        'Aws\Laravel\AwsServiceProvider',
    )
```

Find the `aliases` key in your `config/app.php` and add the AWS facade alias.

```php
    'aliases' => array(
        // ...
        'AWS' => 'Aws\Laravel\AwsFacade',
    )
```

## Configuration

By default, the package uses the following environment variables to auto-configure the plugin without modification:
```
AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
AWS_REGION              // default = us-east-1
AWS_CONFIG_FILE         // default = null
```

To customize the configuration file, publish the package configuration using Artisan.

```sh
php artisan vendor:publish
```

Update your settings in the generated `app/config/aws.php` configuration file.

```php
return [
    'key'         => 'YOUR_AWS_ACCESS_KEY_ID',
    'secret'      => 'YOUR_AWS_SECRET_KEY',
    'region'      => 'us-east-1',
    'config_file' => null,
];
```

## Usage

In order to use the AWS SDK for PHP within your app, you need to retrieve it from the [Laravel IoC
Container](http://laravel.com/docs/ioc). The following example uses the Amazon S3 client to upload a file.

```php
$s3 = App::make('aws')->get('s3');
$s3->putObject(array(
    'Bucket'     => 'YOUR_BUCKET',
    'Key'        => 'YOUR_OBJECT_KEY',
    'SourceFile' => '/the/path/to/the/file/you/are/uploading.ext',
));
```

If the AWS facade is registered within the `aliases` section of the application configuration, you can also use the
following technique.

```php
$s3 = AWS::get('s3');
$s3->putObject(array(
    'Bucket'     => 'YOUR_BUCKET',
    'Key'        => 'YOUR_OBJECT_KEY',
    'SourceFile' => '/the/path/to/the/file/you/are/uploading.ext',
));
```

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php/)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws/)
* [License](http://aws.amazon.com/apache2.0/)
* [Laravel website](http://laravel.com/)
