<?php namespace Aws\Laravel\Test;

use Aws\Laravel\AwsFacade as AWS;
use Aws\Laravel\AwsServiceProvider;
use Illuminate\Container\Container;

abstract class AwsServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testFacadeCanBeResolvedToServiceInstance()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Mount facades
        AWS::setFacadeApplication($app);

        // Get an instance of a client (S3) via the facade.
        $s3 = AWS::createClient('S3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);
    }

    public function testRegisterAwsServiceProviderWithPackageConfigAndEnv()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Get an instance of a client (S3).
        /** @var $s3 \Aws\S3\S3Client */
        $s3 = $app['aws']->createClient('S3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);

        // Verify that the client received the credentials from the package config.
        /** @var \Aws\Credentials\CredentialsInterface $credentials */
        $credentials = $s3->getCredentials()->wait();
        $this->assertEquals('foo', $credentials->getAccessKeyId());
        $this->assertEquals('bar', $credentials->getSecretKey());
        $this->assertEquals('baz', $s3->getRegion());
    }

    public function testServiceNameIsProvided()
    {
        $app = $this->setupApplication();
        $provider = $this->setupServiceProvider($app);
        $this->assertContains('aws', $provider->provides());
    }

    public function testVersionInformationIsProvidedToSdkUserAgent()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);
        $config = $app['config']->get('aws');

        $this->assertArrayHasKey('ua_append', $config);
        $this->assertInternalType('array', $config['ua_append']);
        $this->assertNotEmpty($config['ua_append']);
        $this->assertNotEmpty(array_filter($config['ua_append'], function ($ua) {
            return false !== strpos($ua, AwsServiceProvider::VERSION);
        }));
    }

    /**
     * @return Container
     */
    abstract protected function setupApplication();

    /**
     * @param Container $app
     *
     * @return AwsServiceProvider
     */
    private function setupServiceProvider(Container $app)
    {
        // Create and register the provider.
        $provider = new AwsServiceProvider($app);
        $app->register($provider);
        $provider->boot();

        return $provider;
    }
}
