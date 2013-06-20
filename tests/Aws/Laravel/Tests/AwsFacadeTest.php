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

namespace Aws\Laravel\Tests;

use Aws\Laravel\AwsFacade as AWS;
use Aws\Laravel\AwsServiceProvider;
use Illuminate\Foundation\Application;

/**
 * AwsFacade test cases
 */
class AwsFacadeTest extends \PHPUnit_Framework_TestCase
{
    public function testFacadeCanBeResolvedToServiceInstance()
    {
        // Setup the Laravel app and AWS service provider
        $app = new Application();
        $provider = new AwsServiceProvider($app);
        $app->register($provider, array(
            'config' => array(
                'aws' => array(
                    'key'    => 'your-aws-access-key-id',
                    'secret' => 'your-aws-secret-access-key',
                ),
            ),
        ));
        $provider->boot();

        AWS::setFacadeApplication($app);

        // Get an instance of a client (S3) to use for testing
        /** @var $s3 \Aws\S3\S3Client */
        $s3 = AWS::get('s3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);
    }
}
