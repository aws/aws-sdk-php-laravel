# AWS Service Provider for Laravel 4

[![Latest Stable Version](https://poser.pugx.org/aws/aws-sdk-php-laravel/v/stable.png)](https://packagist.org/packages/aws/aws-sdk-php-laravel)
[![Total Downloads](https://poser.pugx.org/aws/aws-sdk-php-laravel/downloads.png)](https://packagist.org/packages/aws/aws-sdk-php-laravel)

A simple [Laravel 4](http://four.laravel.com/) service provider for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

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

## Usage

To use the AWS Service Provider, you must register the provider when bootstrapping your Laravel application. There are
essentially two ways to do this.

### 1. Use Laravel Configuration

Publish the package configuration from the command line:

```php
php artisan config:publish aws/aws-sdk-php-laravel`
```

Update your settings in the generated `app/config/packages/aws/aws-sdk-php-laravel` configuration file:

```php
return array(
    'key'    => 'your-aws-access-key-id',
    'secret' => 'your-aws-secret-access-key',
    'region' => Aws\Common\Enum\Region::US_WEST_2,
);
```

Find the `providers` key in `app/config/app.php` and register the AWS Service Provider.

```php
    'providers' => array(
        // ...
        'Aws\Laravel\AwsServiceProvider',
    )
```

Find the `aliases` key in `app/config/app.php` and add the AWS facade alias.

```php
    'aliases' => array(
        // ...
        'AWS' => 'Aws\Laravel\AwsFacade',
    )
```

### 2. Manual Instantiation

You can also register the provider and configuration options at runtime. This could be done in your global bootstrapping
process in `app/start/global.php`.

```php
use Aws\Common\Enum\Region;
use Aws\Laravel\AwsServiceProvider;
use Illuminate\Foundation\Application;

// Instantiate a new application. This is normally done by the Laravel framework and the instance is available in
// `app/start/global.php` for you to use.
$app = new Application;

// Register the AWS service provider and provide your configuration
$app->register(new AwsServiceProvider($app), array(
    'config' => array(
        'aws' => array(
            'key'    => '<your-aws-access-key-id>',
            'secret' => '<your-aws-secret-access-key>',
            'region' => Region::US_WEST_2,
        ),
    ),
));
```

You can alternatively specify the path to an AWS config file (see [AWS SDK for PHP](http://github.com/aws/aws-sdk-php)
for details about how to format this type of file).

```php
$app->register(new AwsServiceProvider($app), array('config' => array('aws' => '/path/to/aws/config/file.php')));
```

Either way, the value of `$app['config']['aws']` is passed directly into `Aws\Common\Aws::factory()`.

### Retrieving and Using a Service Client

In order to use the SDK from within your app, you need to retrieve it from the [Laravel IoC
Container](http://four.laravel.com/docs/ioc). The following example uses the Amazon S3 client to upload a file.

```php
$s3 = App::make('aws')->get('s3');
$s3->putObject(array(
    'Bucket'     => '<your-bucket>',
    'Key'        => '<the-name-of-your-object>',
    'SourceFile' => '/path/to/the/file/you/are/uploading.ext',
));
```

If the AWS Facade is registered within the `aliases` section of the application configuration, you can use
the following more expressive method.

```php
$s3 = AWS::get('s3');
$s3->putObject(array(
    'Bucket'     => '<your-bucket>',
    'Key'        => '<the-name-of-your-object>',
    'SourceFile' => '/path/to/the/file/you/are/uploading.ext',
));
```

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Laravel website](http://laravel.com)
