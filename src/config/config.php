<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Key
	|--------------------------------------------------------------------------
	|
	| The key is used to authenticate with your bucket. The key can be optained
	| from https://portal.aws.amazon.com/gp/aws/securityCredentials
	|
	*/

	'key' => 'your-aws-access-key-id',
	
	/*
	|--------------------------------------------------------------------------
	| Secret Key
	|--------------------------------------------------------------------------
	|
	| The sectret key will be used to authenticate with your bucket. The key
	| can be optained from https://portal.aws.amazon.com/gp/aws/securityCredentials
	|
	*/

	'secret' => 'your-aws-secret-access-key',

	/*
	|--------------------------------------------------------------------------
	| AWS Region
	|--------------------------------------------------------------------------
	|
	| The AWS Region is the region with which you wish to connnect
	|
	*/

	'region' => Aws\Common\Enum\Region::US_WEST_2,


);