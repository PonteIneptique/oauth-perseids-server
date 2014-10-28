<?php
	$app = new Silex\Application(); 
	$app->register(new AuthBucket\OAuth2\Provider\AuthBucketOAuth2ServiceProvider());

	/* Debug Mode */
	$app['debug'] = true;

	return $app;
?>