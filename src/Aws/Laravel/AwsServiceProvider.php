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

namespace Aws\Laravel;

use Aws\Sdk;
use Illuminate\Support\ServiceProvider;

/**
 * AWS SDK for PHP service provider for Laravel applications
 */
class AwsServiceProvider extends ServiceProvider
{
    const VERSION = '1.5.0';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('aws', function ($app) {
            // Retrieve the config
            $config = $app['config']['aws'] ?: $app['config']['aws::config'];

            // Instantiate the AWS service builder
            $aws = new Sdk($config);

            return $aws;
        });

        $this->app->alias('aws', 'Aws\Sdk');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('aws/aws-sdk-php-laravel', 'aws');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('aws', 'Aws\Sdk');
    }
}
