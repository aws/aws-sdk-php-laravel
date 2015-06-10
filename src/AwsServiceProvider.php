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
        $source = realpath(__DIR__ . '/../config/aws.php');

        if (class_exists('Illuminate\Foundation\Application', false)) {
            $this->publishes([$source => config_path('aws.php')]);
        }

        $this->mergeConfigFrom($source, 'aws');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('aws', function ($app) {
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
