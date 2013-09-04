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

namespace Aws\Laravel\Test;

use Aws\Laravel\AwsFacade as AWS;

/**
 * AwsFacade test cases
 */
class AwsFacadeTest extends AwsServiceProviderTestCase
{
    public function testFacadeCanBeResolvedToServiceInstance()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Mount facades
        AWS::setFacadeApplication($app);

        // Get an instance of a client (S3) via its facade
        $s3 = AWS::get('s3');
        $this->assertInstanceOf('Aws\S3\S3Client', $s3);
    }
}
