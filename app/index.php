<?php
	/* Configuration of the dependencies */
	require_once __DIR__.'/../vendor/autoload.php'; 

	$app = require __DIR__.'/../src/app.php';
	$app->boot();
	$app->run(); 
	/*
	print_r($app['security.authentication_provider.oauth2_token._proto']);
	exit();
	print_r($app["security"]->getToken());
	*/
?>