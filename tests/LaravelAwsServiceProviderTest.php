<?php namespace Aws\Laravel\Test;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

class LaravelAwsServiceProviderTest extends AwsServiceProviderTest
{
    protected function setupApplication()
    {
        if (!class_exists(Application::class)) {
            $this->markTestSkipped();
        }
        // Create the application such that the config is loaded.
        $app = new Application();
        $app->setBasePath(sys_get_temp_dir());
        $app->instance('config', new Repository());

        return $app;
    }
}
