<?php
/**
 * Copyright 2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

return array(

    /*
    |--------------------------------------------------------------------------
    | Your AWS Credentials
    |--------------------------------------------------------------------------
    |
    | In order to communicate with an AWS service, you must provide your AWS
    | credentials including your AWS Access Key ID and your AWS Secret Key.
    |
    | To use credentials from your credentials file or environment or to use
    | IAM Instance Profile credentials, please remove these config settings from
    | your config or make sure they are null. For more information see:
    | http://docs.aws.amazon.com/aws-sdk-php-2/guide/latest/configuration.html
    |
    */
    'key'    => null, // Your AWS Access Key ID
    'secret' => null, // Your AWS Secret Access Key

    /*
    |--------------------------------------------------------------------------
    | AWS Region
    |--------------------------------------------------------------------------
    |
    | Many AWS services are available in multiple regions. You should specify
    | the AWS region you would like to use, but please remember that not every
    | service is available in every region.
    |
    | These are the regions: us-east-1, us-west-1, us-west-2, us-gov-west-1
    | eu-west-1, sa-east-1, ap-northeast-1, ap-southeast-1, ap-southeast-2
    |
    */
    'region' => 'us-east-1',

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
    'config_file' => null,

);
