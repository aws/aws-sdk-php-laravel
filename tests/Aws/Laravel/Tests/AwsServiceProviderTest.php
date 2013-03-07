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

use Aws\Laravel\AwsServiceProvider;
use Illuminate\Foundation\Application;

/**
 * AwsServiceProvider test cases
 */
class AwsServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterAwsServiceProvider()
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

        // Get an instance of a client (S3) to use for testing
        /** @var $s3 \Aws\S3\S3Client */
        $s3 = $app['aws']->get('s3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);

        // Verify that the app and clients created by the SDK receive the provided credentials
        $this->assertEquals('your-aws-access-key-id', $app['config']['aws']['key']);
        $this->assertEquals('your-aws-secret-access-key', $app['config']['aws']['secret']);
        $this->assertEquals('your-aws-access-key-id', $s3->getCredentials()->getAccessKeyId());
        $this->assertEquals('your-aws-secret-access-key', $s3->getCredentials()->getSecretKey());

        // Make sure the user agent contains "Laravel"
        $command = $s3->getCommand('ListBuckets');
        $request = $command->prepare();
        $s3->dispatch('command.before_send', array('command' => $command));
        $this->assertRegExp('/.+Laravel\/.+/', $request->getHeader('User-Agent', true));
    }

    /**
     * @expectedException \Aws\Common\Exception\InstanceProfileCredentialsException
     */
    public function testNoConfigProvided()
    {
        // Setup the Laravel app and AWS service provider
        $app = new Application();
        $provider = new AwsServiceProvider($app);
        $app->register($provider);
        $provider->boot();

        // Make sure we can still get the S3Client
        /** @var $s3 \Aws\S3\S3Client */
        $s3 = $app['aws']->get('s3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);

        // Trigger the expected exception
        $s3->getCredentials()->getAccessKeyId();
    }
}
