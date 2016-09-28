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

namespace Aws\Laravel\Test;

use Aws\Laravel\AwsServiceProvider;
use Illuminate\Foundation\Application;


/**
 * AwsServiceProvider test cases
 */
class AwsServiceProviderTest extends AwsServiceProviderTestCase
{
    public function testRegisterAwsServiceProviderWithGlobalConfig()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Get an instance of a client (S3)
        /** @var $s3 \Aws\S3\S3Client */
        $s3 = $app['aws']->createClient('s3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);

        // Verify that the client received the credentials from the global config
        $credentials = $s3->getCredentials()->wait();
        $this->assertEquals('', $credentials->getAccessKeyId());
        $this->assertEquals('', $credentials->getSecretKey());

        // Make sure the user agent contains Laravel information
        $config = $app['config']['aws'] ?: $app['config']['aws::config'];

        $this->assertArrayHasKey('ua_append', $config);
        $this->assertInternalType('array', $config['ua_append']);
        $this->assertNotEmpty($config['ua_append']);
        $this->assertNotEmpty(array_filter($config['ua_append'], function ($ua) {
            return false !== strpos($ua, AwsServiceProvider::VERSION);
        }));
    }

    public function testRegisterAwsServiceProviderWithPackageConfig()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Get an instance of a client (S3)
        /** @var $s3 \Aws\S3\S3Client */
        $s3 = $app['aws']->createClient('s3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);

        // Verify that the client received the credentials from the package config
        $credentials = $s3->getCredentials()->wait();
        $this->assertEquals('', $credentials->getAccessKeyId());
        $this->assertEquals('', $credentials->getSecretKey());
    }

    public function testServiceNameIsProvided()
    {
        $app = $this->setupApplication();
        $provider = $this->setupServiceProvider($app);
        $this->assertContains('aws', $provider->provides());
    }
}
