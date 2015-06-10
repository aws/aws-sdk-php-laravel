<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Your AWS Credentials
    |--------------------------------------------------------------------------
    |
    | In order to communicate with an AWS service, you must provide your AWS
    | credentials including your AWS Access Key ID and AWS Secret Access Key.
    |
    | To use credentials from your credentials file or environment or to use
    | IAM Instance Profile credentials, please remove these config settings from
    | your config or make sure they are null. For more information, see:
    | http://docs.aws.amazon.com/aws-sdk-php-2/guide/latest/configuration.html
    |
    */
    'key'    => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),

    /*
    |--------------------------------------------------------------------------
    | AWS Region
    |--------------------------------------------------------------------------
    |
    | Many AWS services are available in multiple regions. You should specify
    | the AWS region you would like to use, but please remember that not every
    | service is available in every region. To see what regions are available,
    | see: http://docs.aws.amazon.com/general/latest/gr/rande.html
    |
    */
    'region' => env('AWS_REGION', 'us-east-1'),

    /*
    |--------------------------------------------------------------------------
    | AWS Config File Location
    |--------------------------------------------------------------------------
    |
    | Instead of specifying your credentials and region here, you can specify
    | the location of an AWS SDK for PHP config file to use. These files provide
    | more granular control over what credentials and regions you are using for
    | each service. If you specify a filepath for this configuration setting,
    | the others in this file will be ignored. See the SDK user guide for more
    | information: http://docs.aws.amazon.com/aws-sdk-php-2/guide/latest/configuration.html#using-a-custom-configuration-file
    |
    */
    'config_file' => env('AWS_CONFIG_FILE'),

];
