<?php
namespace Aws\Laravel\Test;

use Illuminate\Config\Repository;
use Laravel\Lumen\Application;

class LumenAwsServiceProviderTest extends AwsServiceProviderTest
{
    protected function setupApplication()
    {
        // Create the application such that the config is loaded.
        $app = new Application(sys_get_temp_dir());
        $app->instance('config', new Repository());

        return $app;
    }
}
