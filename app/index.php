<?php
	/* Configuration of the dependencies */
	require_once __DIR__.'/../vendor/autoload.php'; 
	$app = new Silex\Application(); 
	$app->register(new AuthBucket\OAuth2\Provider\AuthBucketOAuth2ServiceProvider());

	/* Debug Mode */
	$app['debug'] = true;

	/**********************************
	 *	Routes
	 **********************************/

	$app->run(); 
?>