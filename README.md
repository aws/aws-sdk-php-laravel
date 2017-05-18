# AWS Service Provider for Laravel 5

[![@awsforphp on Twitter](http://img.shields.io/badge/twitter-%40awsforphp-blue.svg?style=flat)](https://twitter.com/awsforphp)
[![Build Status](https://img.shields.io/travis/aws/aws-sdk-php-laravel.svg)](https://travis-ci.org/aws/aws-sdk-php-laravel)
[![Latest Stable Version](https://img.shields.io/packagist/v/aws/aws-sdk-php-laravel.svg)](https://packagist.org/packages/aws/aws-sdk-php-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/aws/aws-sdk-php-laravel.svg)](https://packagist.org/packages/aws/aws-sdk-php-laravel)
[![Gitter](https://badges.gitter.im/gitterHQ/gitter.png)](https://gitter.im/aws/aws-sdk-php)

This is a simple [Laravel](http://laravel.com/) service provider for making it easy to include the official
[AWS SDK for PHP](https://github.com/aws/aws-sdk-php) in your Laravel and Lumen applications.

This README is for version 3.x of the service provider, which is implemented to work with Version 3 of the AWS SDK for
PHP and Laravel 5.1.

**Major Versions:**

* **3.x** (YOU ARE HERE) - For `laravel/framework:~5.1` and `aws/aws-sdk-php:~3.0`
* **2.x** ([2.0 branch](https://github.com/aws/aws-sdk-php-laravel/tree/2.0)) - For `laravel/framework:5.0.*` and `aws/aws-sdk-php:~2.4`
* **1.x** ([1.0 branch](https://github.com/aws/aws-sdk-php-laravel/tree/1.0)) - For `laravel/framework:4.*` and `aws/aws-sdk-php:~2.4`

## Installation

The AWS Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`aws/aws-sdk-php-laravel` package in your project's `composer.json`.

```json
{
    "require": {
        "aws/aws-sdk-php-laravel": "~3.0"
    }
}
```

Then run a composer update
```sh
php composer.phar update
```

To use the AWS Service Provider, you must register the provider when bootstrapping your application.


### Lumen
In Lumen find the `Register Service Providers` in your `bootstrap/app.php` and register the AWS Service Provider.

```php
    $app->register(Aws\Laravel\AwsServiceProvider::class);
```

### Laravel
In Laravel find the `providers` key in your `config/app.php` and register the AWS Service Provider.

```php
    'providers' => array(
        // ...
        Aws\Laravel\AwsServiceProvider::class,
    )
```

Find the `aliases` key in your `config/app.php` and add the AWS facade alias.

```php
    'aliases' => array(
        // ...
        'AWS' => Aws\Laravel\AwsFacade::class,
    )
```

## Configuration

By default, the package uses the following environment variables to auto-configure the plugin without modification:
```
AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
AWS_REGION (default = us-east-1)
```

To customize the configuration file, publish the package configuration using Artisan.

```sh
php artisan vendor:publish
```

Update your settings in the generated `app/config/aws.php` configuration file.

```php
return [
    'credentials' => [
        'key'    => 'YOUR_AWS_ACCESS_KEY_ID',
        'secret' => 'YOUR_AWS_SECRET_ACCESS_KEY',
    ],
    'region' => 'us-west-2',
    'version' => 'latest',
    
    // You can override settings for specific services
    'Ses' => [
        'region' => 'us-east-1',
    ],
];
```

Referring Laravel 5.2.0 [Upgrade guide](https://laravel.com/docs/5.2/upgrade#upgrade-5.2.0), you must using config 
file instead of environment variable option if using php artisan `config:cache`.

Learn more about [configuring the SDK](http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html) on
the SDK's User Guide.

## Usage

In order to use the AWS SDK for PHP within your app, you need to retrieve it from the [Laravel IoC
Container](http://laravel.com/docs/ioc). The following example uses the Amazon S3 client to upload a file.

```php
$s3 = App::make('aws')->createClient('s3');
$s3->putObject(array(
    'Bucket'     => 'YOUR_BUCKET',
    'Key'        => 'YOUR_OBJECT_KEY',
    'SourceFile' => '/the/path/to/the/file/you/are/uploading.ext',
));
```

If the AWS facade is registered within the `aliases` section of the application configuration, you can also use the
following technique.

```php
$s3 = AWS::createClient('s3');
$s3->putObject(array(
    'Bucket'     => 'YOUR_BUCKET',
    'Key'        => 'YOUR_OBJECT_KEY',
    'SourceFile' => '/the/path/to/the/file/you/are/uploading.ext',
));
```

## `dynamodb` Session Driver

This package publishes the [AWS DynamoDb session driver](https://docs.aws.amazon.com/aws-sdk-php/v2/guide/feature-dynamodb-session-handler.html) 
for use in Laravel. You must first [create a DynamoDb table for your PHP sessions](https://docs.aws.amazon.com/aws-sdk-php/v2/guide/feature-dynamodb-session-handler.html#create-a-table-for-storing-your-sessions) 
and then configure your application.

Using the DynamoDb driver is exactly the same as any other [Laravel session driver](https://laravel.com/docs/5.4/session). 
Simply change your `driver` configuration option to `dynamodb` and add/update any of the following configuration options 
([see AWS docs](https://docs.aws.amazon.com/aws-sdk-php/v2/guide/feature-dynamodb-session-handler.html#configuration) for 
more information, and please note that `table` and `lifetime` have been renamed to be consistent with all other Laravel 
session drivers):

* `table`: This should be the name of the DynamoDb table you created
* `hash_key`: Name of hash key in table (default is `id`)
* `lifetime`: Session lifetime
* `consistent_read`: Whether or not to use consistent reads
* `batch_config`: Batch options used for garbage collection
* `locking`: Whether or not to use session locking
* `max_lock_wait_time`: Max time (in seconds) to wait for lock acquisition
* `min_lock_retry_microtime`: Min time (in µs) to wait between lock attempts
* `max_lock_retry_microtime`: Max time (in µs) to wait between lock attempts

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php/)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws/)
* [DynamoDb Session Handler](https://docs.aws.amazon.com/aws-sdk-php/v2/guide/feature-dynamodb-session-handler.html)
* [License](http://aws.amazon.com/apache2.0/)
* [Laravel website](http://laravel.com/)