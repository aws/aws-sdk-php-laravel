# AWS Service Provider for Laravel 4

A simple [Laravel 4](http://four.laravel.com/) service provider for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

## Installation

The AWS Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`aws/aws-sdk-php-laravel` package and setting the `minimum-stability` to `dev` (required for Laravel 4) in your
project's `composer.json`.

```json
{
    "require": {
        "laravel/framework": "4.0.*",
        "aws/aws-sdk-php-laravel": "1.*"
    },
    "minimum-stability": "dev"
}
```

## Usage

First you have to register the AWS Service Provider when bootstraping your Laravel application. Create a new `app/config/aws.php` configuration file with the following options.

```php
return array(
    'key'    => '<your-aws-access-key-id>',
    'secret' => '<your-aws-secret-access-key>',
    'region' => Region::US_WEST_2,
);
```

Now find the `providers` key in `app/config/app.php` and register the AWS Service Provider.

```php
'providers' => array(

    ....

    'Aws\Laravel\AwsServiceProvider',

)
```

Or if you'd like to register the configuration options at runtime.

```php
use Aws\Common\Enum\Region;
use Aws\Laravel\AwsServiceProvider;
use Illuminate\Foundation\Application;

// Instantiate a new application. This is done by the Laravel framework and the instance is available
// in app/start/global.php for you to use.
$app = new Application;

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

*Or* you can specify the path to an AWS config file (see [AWS SDK for PHP](http://github.com/aws/aws-sdk-php) for
details).

```php
$app->register(new AwsServiceProvider($app), array('config' => array('aws' => '/path/to/aws/config/file.php')));
```

Either way, the value of `$app['config']['aws']` is passed directly into `Aws\Common\Aws::factory()`.

In order to use the SDK from within your app, you need to retrieve it from the [Laravel IoC
Container](http://four.laravel.com/docs/ioc).

```php
$s3 = App::make('aws')->get('s3');
$s3->putObject(array(
    'Bucket'     => '<your-bucket>',
    'Key'        => 'the-name-of-your-object',
    'SourceFile' => '/path/to/the/file/you/are/uploading.ext',
));
```

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Laravel website](http://laravel.com)
