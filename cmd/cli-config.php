<?php
	use Doctrine\ORM\Tools\Console\ConsoleRunner;

	// replace with file to your own project bootstrap
	

	// replace with mechanism to retrieve EntityManager in your app
	$entityManager = require_once __DIR__.'/bootstrap.php';

	return ConsoleRunner::createHelperSet($entityManager);
