<?php namespace Aws\Laravel;

use Aws\Common\Aws;
use Illuminate\Support\ServiceProvider;

/**
 * AWS SDK for PHP service provider for Laravel applications
 */
class AwsServiceProvider extends ServiceProvider {

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
            // Retrieve config.
            $config = $app['config']->get('aws');
            if (isset($config['config_file'])) {
                $config = $config['config_file'];
            }

            return Aws::factory($config);
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
