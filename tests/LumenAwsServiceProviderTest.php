<?php
namespace Aws\Laravel\Test;

use Illuminate\Config\Repository;
use Laravel\Lumen\Application;
use Mockery as M;

class LumenAwsServiceProviderTest extends AwsServiceProviderTest
{
    public function setUp()
    {
        if (!class_exists(Application::class)) {
            $this->markTestSkipped();
        }

        parent::setUp();
    }

    protected function setupApplication()
    {
        // Create the application such that the config is loaded.
        $app = new Application(sys_get_temp_dir());
        $app->instance('config', new Repository());

        return $app;
    }

    public function testSessionDriverIsNotRegistered()
    {
        $app = $this->setupApplication();
        $app->resolving('session', function() {
            $this->fail('Should not resolve session when boot() is called in Lumen context.');
        });
        $this->setupServiceProvider($app);
    }
}
