<?php namespace Aws\Laravel\Test;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Mockery as M;

class LaravelAwsServiceProviderTest extends AwsServiceProviderTest
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
        $app = new Application();
        $app->setBasePath(sys_get_temp_dir());
        $app->instance('config', new Repository());

        return $app;
    }

    public function testSessionDriverIsRegistered()
    {
        $app = $this->setupApplication();

        $session = M::mock(StdClass::class);
        $session->shouldReceive('extend')->with('dynamodb', \Closure::class)->once();
        $app->instance('session', $session);

        $this->setupServiceProvider($app);

        M::close();
    }
}
