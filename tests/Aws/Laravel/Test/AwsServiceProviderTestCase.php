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
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Filesystem\Filesystem;

/**
 * AwsServiceProvider Base Test Case
 */
abstract class AwsServiceProviderTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Application
     */
    protected function setupApplication()
    {
        // Create the application such that the config is loaded
        $app = new Application();
        $app->instance('path', 'foobar');
        $app->instance('files', new Filesystem);
        $app->instance('config', new Repository($app->getConfigLoader(), 'foobar'));

        return $app;
    }

    /**
     * @param Application $app
     *
     * @return AwsServiceProvider
     */
    protected function setupServiceProvider(Application $app)
    {
        // Create and register the provider
        $provider = new AwsServiceProvider($app);
        $app->register($provider);
        $provider->boot();

        return $provider;
    }
}
