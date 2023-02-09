<?php

use Aws\Laravel\AwsServiceProvider;
use Illuminate\Support\Facades\App;


if (version_compare(App::version(), '5.8.0', '>=')) {
    $awsRegion = env('AWS_DEFAULT_REGION', 'us-east-1');
} else {
    $awsRegion = env('AWS_REGION', 'us-east-1');
}

return [

    /*
    |--------------------------------------------------------------------------
    | AWS SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options set in this file will be passed directly to the
    | `Aws\Sdk` object, from which all client objects are created. This file
    | sets the default minimum configuration used by the service provider even
    | if no configuration is set by the user. The full set of possible options
    | are documented at:
    | http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
    |
    */
    'region' => $awsRegion,
    'version' => 'latest',
    'ua_append' => [
        'L5MOD/' . AwsServiceProvider::VERSION,
    ],
];
