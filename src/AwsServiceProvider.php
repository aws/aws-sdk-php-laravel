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

use Aws\Common\Aws;
use Aws\Common\Client\UserAgentListener;
use Guzzle\Common\Event;
use Guzzle\Service\Client;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * AWS SDK for PHP service provider for Laravel applications
 */
class AwsServiceProvider extends ServiceProvider
{

    const VERSION = '2.0.0';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $config = realpath(__DIR__ . '/../config/config.php');

        $this->mergeConfigFrom($config, 'aws');

        $this->publishes([$config => config_path('aws.php')], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('aws', function ($app) {
            // Instantiate the AWS service builder
            $aws = Aws::factory($app['config']->get('aws'));

            // Attach an event listener that will append the Laravel and module version numbers to the user agent string
            $aws->getEventDispatcher()->addListener('service_builder.create_client', function (Event $event) {
                $clientConfig = $event['client']->getConfig();
                $commandParams = $clientConfig->get(Client::COMMAND_PARAMS) ?: [];
                $userAgentSuffix = 'Laravel/' . Application::VERSION . ' L5MOD/' . AwsServiceProvider::VERSION;

                $clientConfig->set(Client::COMMAND_PARAMS, array_merge_recursive($commandParams, [
                    UserAgentListener::OPTION => $userAgentSuffix,
                ]));
            });

            return $aws;
        });

        $this->app->alias('aws', 'Aws\Common\Aws');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['aws', 'Aws\Common\Aws'];
    }
}
