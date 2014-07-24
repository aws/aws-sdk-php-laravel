# AWS Service Provider for Laravel 4

[![Latest Stable Version](https://poser.pugx.org/aws/aws-sdk-php-laravel/v/stable.png)](https://packagist.org/packages/aws/aws-sdk-php-laravel)
[![Total Downloads](https://poser.pugx.org/aws/aws-sdk-php-laravel/downloads.png)](https://packagist.org/packages/aws/aws-sdk-php-laravel)

A simple [Laravel 4](http://laravel.com/) service provider for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

## Installation

The AWS Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`aws/aws-sdk-php-laravel` package in your project's `composer.json`.

```json
{
    "require": {
        "aws/aws-sdk-php-laravel": "1.*"
    }
}
```

Then run a composer update
```sh
php composer.phar update
```

## Configuration

To use the AWS Service Provider, you must register the provider when bootstrapping your Laravel application.

Publish the package configuration using Artisan.

```sh
php artisan config:publish aws/aws-sdk-php-laravel
```

Update your settings in the generated `app/config/packages/aws/aws-sdk-php-laravel` configuration file.

```php
return array(
    'key'         => 'YOUR_AWS_ACCESS_KEY_ID',
    'secret'      => 'YOUR_AWS_SECRET_KEY',
    'region'      => 'us-east-1',
    'config_file' => null,
);
```

Find the `providers` key in your `app/config/app.php` and register the AWS Service Provider.

```php
    'providers' => array(
        // ...
        'Aws\Laravel\AwsServiceProvider',
    )
```

Find the `aliases` key in your `app/config/app.php` and add the AWS facade alias.

```php
    'aliases' => array(
        // ...
        'AWS' => 'Aws\Laravel\AwsFacade',
    )
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
