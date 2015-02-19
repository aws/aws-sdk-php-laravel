<?php namespace Aws\Laravel;

use Aws\Common\Client\AwsClientInterface;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for the AWS service
 *
 * @method static AwsClientInterface get($name, $throwAway = false) Get a client from the service builder
 */
class AwsFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'aws';
    }

}
