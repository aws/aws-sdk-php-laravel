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

/**
 * AwsServiceProvider test cases
 */
class AwsServiceProviderTest extends AwsServiceProviderTestCase
{
    public function testRegisterAwsServiceProviderWithGlobalConfig()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Simulate global config; specify config file
        $app['config']->set('aws', array(
            'config_file' => __DIR__ . '/test_services.json'
        ));

        // Get an instance of a client (S3)
        /** @var $s3 \Aws\S3\S3Client */
        $s3 = $app['aws']->get('s3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);

        // Verify that the client received the credentials from the global config
        $this->assertEquals('change_me', $s3->getCredentials()->getAccessKeyId());
        $this->assertEquals('change_me', $s3->getCredentials()->getSecretKey());

        // Make sure the user agent contains Laravel information
        $command = $s3->getCommand('ListBuckets');
        $request = $command->prepare();
        $s3->dispatch('command.before_send', array('command' => $command));
        $this->assertRegExp('/.+Laravel\/.+L4MOD\/.+/', (string) $request->getHeader('User-Agent'));
    }

    public function testRegisterAwsServiceProviderWithPackageConfig()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Get an instance of a client (S3)
        /** @var $s3 \Aws\S3\S3Client */
        $s3 = $app['aws']->get('s3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);

        // Verify that the client received the credentials from the package config
        $this->assertEquals('YOUR_AWS_ACCESS_KEY_ID', $s3->getCredentials()->getAccessKeyId());
        $this->assertEquals('YOUR_AWS_SECRET_KEY', $s3->getCredentials()->getSecretKey());
    }

    public function testServiceNameIsProvided()
    {
        $app = $this->setupApplication();
        $provider = $this->setupServiceProvider($app);
        $this->assertContains('aws', $provider->provides());
    }
}
