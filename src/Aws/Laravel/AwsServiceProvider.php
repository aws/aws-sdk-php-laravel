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
use Illuminate\Support\Facades\Config;

/**
 * AWS SDK for PHP service provider for Laravel applications
 */
class AwsServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        // Register config file.
        $this->app['config']->package('aws/aws-sdk-php-laravel', __DIR__.'/../../config');

        $this->app['aws'] = $this->app->share(function ($app) {
            // Instantiate the AWS service builder
            $config = $app['config']['aws'] ?: Config::get('aws-sdk-php-laravel::config');
            $aws = Aws::factory($config);

            // Attach an event listener that will append the Laravel version number in the user agent string
            $aws->getEventDispatcher()->addListener('service_builder.create_client', function (Event $event) {
                // The version number is only available in BETA4+, so an extra check is needed
                $version = defined('Illuminate\Foundation\Application::VERSION') ? Application::VERSION : '4.0.0';

                // Add the listener to modify the UA string
                $clientConfig = $event['client']->getConfig();
                $commandParams = $clientConfig->get(Client::COMMAND_PARAMS) ?: array();
                $clientConfig->set(Client::COMMAND_PARAMS, array_merge_recursive($commandParams, array(
                    UserAgentListener::OPTION => "Laravel/{$version}",
                )));
            });

            return $aws;
        });
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
    }
}
