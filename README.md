# AWS Service Provider for Laravel 5/6/7/8

[![@awsforphp on Twitter](http://img.shields.io/badge/twitter-%40awsforphp-blue.svg?style=flat)](https://twitter.com/awsforphp)
[![Build Status](https://img.shields.io/travis/aws/aws-sdk-php-laravel.svg)](https://travis-ci.org/aws/aws-sdk-php-laravel)
[![Latest Stable Version](https://img.shields.io/packagist/v/aws/aws-sdk-php-laravel.svg)](https://packagist.org/packages/aws/aws-sdk-php-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/aws/aws-sdk-php-laravel.svg)](https://packagist.org/packages/aws/aws-sdk-php-laravel)
[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/aws/aws-sdk-php?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

This is a simple [Laravel](http://laravel.com/) service provider for making it easy to include the official
[AWS SDK for PHP](https://github.com/aws/aws-sdk-php) in your Laravel and Lumen applications.

This README is for version 3.x of the service provider, which is implemented to work with Version 3 of the AWS SDK for
PHP and Laravel 5.1.

**Major Versions:**

* **3.x** (YOU ARE HERE) - For `laravel/framework:~5.1|~6.0|~7.0|~8.0` and `aws/aws-sdk-php:~3.0`
* **2.x** ([2.0 branch](https://github.com/aws/aws-sdk-php-laravel/tree/2.0)) - For `laravel/framework:5.0.*` and `aws/aws-sdk-php:~2.4`
* **1.x** ([1.0 branch](https://github.com/aws/aws-sdk-php-laravel/tree/1.0)) - For `laravel/framework:4.*` and `aws/aws-sdk-php:~2.4`

Jump To:
* [Getting Started](_#Getting-Started_)
* [Getting Help](_#Getting-Help_)
* [Contributing](_#Contributing_)
* [More Resources](_#Resources_)

## Getting Started

### Installation
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


#### Lumen
In Lumen find the `Register Service Providers` in your `bootstrap/app.php` and register the AWS Service Provider.

```php
    $app->register(Aws\Laravel\AwsServiceProvider::class);
```

#### Laravel
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

### Configuration

By default, the package uses the following environment variables to auto-configure the plugin without modification:
```
AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
AWS_REGION (default = us-east-1)
```

To customize the configuration file, publish the package configuration using Artisan.

```sh
php artisan vendor:publish  --provider="Aws\Laravel\AwsServiceProvider"
```

The settings can be found in the generated `config/aws.php` configuration file. By default, the credentials and region settings will pull from your `.env` file.

```php
return [
    'credentials' => [
        'key'    => env('AWS_ACCESS_KEY_ID', ''),
        'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
    ],
    'region' => env('AWS_REGION', 'us-east-1'),
    'version' => 'latest',
    
    // You can override settings for specific services
    'Ses' => [
        'region' => 'us-east-1',
    ],
];
```

Note that you can always delete the `credentials` line from this file if you'd like to use the [default SDK Configuration Provider chain](https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials.html#default-credential-chain) instead.

Referring Laravel 5.2.0 [Upgrade guide](https://laravel.com/docs/5.2/upgrade#upgrade-5.2.0), you must using config
file instead of environment variable option if using php artisan `config:cache`.

Learn more about [configuring the SDK](http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html) on
the SDK's User Guide.

### Usage

In order to use the AWS SDK for PHP within your app, you need to retrieve it from the [Laravel Service
Container](https://laravel.com/docs/container#binding). The following example uses the Amazon S3 client to upload a file.

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

## Getting Help

Please use these community resources for getting help. We use the GitHub issues for tracking bugs and feature requests and have limited bandwidth to address them.

* Ask a question on [StackOverflow](https://stackoverflow.com/) and tag it with [`aws-php-sdk`](http://stackoverflow.com/questions/tagged/aws-php-sdk)
* Come join the AWS SDK for PHP [gitter](https://gitter.im/aws/aws-sdk-php)
* Open a support ticket with [AWS Support](https://console.aws.amazon.com/support/home/)
* If it turns out that you may have found a bug, please [open an issue](https://github.com/aws/aws-sdk-php-laravel/issues/new/choose)

This SDK implements AWS service APIs. For general issues regarding the AWS services and their limitations, you may also take a look at the [Amazon Web Services Discussion Forums](https://forums.aws.amazon.com/).

### Opening Issues

If you encounter a bug with `aws-sdk-php-laravel` we would like to hear about it. Search the existing issues and try to make sure your problem doesn’t already exist before opening a new issue. It’s helpful if you include the version of `aws-sdk-php-laravel`, PHP version and OS you’re using. Please include a stack trace and reduced repro case when appropriate, too.

The GitHub issues are intended for bug reports and feature requests. For help and questions with using `aws-sdk-php` please make use of the resources listed in the Getting Help section. There are limited resources available for handling issues and by keeping the list of open issues lean we can respond in a timely manner.

## Contributing

We work hard to provide a high-quality and useful SDK for our AWS services, and we greatly value feedback and contributions from our community. Please review our [contributing guidelines](./CONTRIBUTING.md) before submitting any issues or pull requests to ensure we have all the necessary information to effectively respond to your bug report or contribution.

## Resources

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php/)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws/)
* [License](http://aws.amazon.com/apache2.0/)
* [Laravel website](http://laravel.com/)
