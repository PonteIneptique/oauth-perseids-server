<?php
	$app->get('/', function () use ($app) {
	    return $app['twig']->render('index.twig', array());
	})->bind("index");