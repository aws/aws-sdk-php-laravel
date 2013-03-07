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
use Aws\Common\Exception\RuntimeException;
use Guzzle\Common\Event;
use Guzzle\Service\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

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
        $this->app['aws'] = $this->app->share(function ($app) {
            // Instantiate the AWS service builder
            $config = isset($app['config']['aws']) ? $app['config']['aws'] : array();
            $aws = Aws::factory($config);

            // Attach an event listener that will append the Laravel version number in the user agent string
            $aws->getEventDispatcher()->addListener('service_builder.create_client', function (Event $event) {
                $clientConfig = $event['client']->getConfig();
                $commandParams = $clientConfig->get(Client::COMMAND_PARAMS) ?: array();
                $clientConfig->set(Client::COMMAND_PARAMS, array_merge_recursive($commandParams, array(
                    UserAgentListener::OPTION => 'Laravel' . ( defined('Application::VERSION') ? '/' . Application::VERSION : '' ),
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
