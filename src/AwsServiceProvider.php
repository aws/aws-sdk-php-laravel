<?php namespace Aws\Laravel;

use Aws\Sdk;
use Aws\DynamoDb\SessionHandler;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Laravel\Lumen\Application as LumenApplication;

/**
 * AWS SDK for PHP service provider for Laravel applications
 */
class AwsServiceProvider extends ServiceProvider
{
    const VERSION = '3.2.0';

    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $source = dirname(__DIR__).'/config/aws.php';

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('aws.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('aws');
        }

        $this->mergeConfigFrom($source, 'aws');

        Session::extend('dynamodb', function ($app) {
            $client = $app->make('aws')->createClient('DynamoDb');
            $config = $app->make('config')->get('session');
            return SessionHandler::fromClient($client, array_filter([
                'table_name' => Arr::get($config, 'table'),
                'hash_key' => Arr::get($config, 'hash_key'),
                'session_lifetime' => Arr::get($config, 'lifetime'),
                'consistent_read' => Arr::get($config, 'consistent_read'),
                'batch_config' => Arr::get($config, 'batch_config'),
                'locking' => Arr::get($config, 'locking'),
                'max_lock_wait_time' => Arr::get($config, 'max_lock_wait_time'),
                'min_lock_retry_microtime' => Arr::get($config, 'min_lock_retry_microtime'),
                'max_lock_retry_microtime' => Arr::get($config, 'max_lock_retry_microtime'),
            ]));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('aws', function ($app) {
            $config = $app->make('config')->get('aws');

            return new Sdk($config);
        });

        $this->app->alias('aws', 'Aws\Sdk');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['aws', 'Aws\Sdk'];
    }

}
