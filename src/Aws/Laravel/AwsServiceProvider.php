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
    const VERSION = '1.1.0';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['aws'] = $this->app->share(function ($app) {
            // Retrieve the config
            $config = $app['config']['aws'] ?: $app['config']['aws::config'];
            if (isset($config['config_file'])) {
                $config = $config['config_file'];
            }

            // Instantiate the AWS service builder
            $aws = Aws::factory($config);

            // Attach an event listener that will append the Laravel and module version numbers to the user agent string
            $aws->getEventDispatcher()->addListener('service_builder.create_client', function (Event $event) {
                $clientConfig = $event['client']->getConfig();
                $commandParams = $clientConfig->get(Client::COMMAND_PARAMS) ?: array();
                $userAgentSuffix = 'Laravel/' . Application::VERSION . ' L4MOD/' . AwsServiceProvider::VERSION;
                $clientConfig->set(Client::COMMAND_PARAMS, array_merge_recursive($commandParams, array(
                    UserAgentListener::OPTION => $userAgentSuffix,
                )));
            });

            return $aws;
        });
        
        $this->app->alias('aws', 'Aws\Common\Aws');
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
        return array('aws');
    }
}
