<?php
	// bootstrap.php
	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;

	#~Added
	use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
	use Doctrine\Common\Annotations\AnnotationReader;
	use Doctrine\Common\Cache\FilesystemCache;

	require_once "../vendor/autoload.php";

    $driver = new AnnotationDriver(new AnnotationReader(), array(__DIR__.'/../vendor/authbucket/oauth2-php/tests/AuthBucket/OAuth2/Tests/TestBundle/Entity'));
    $cache = new FilesystemCache(__DIR__.'/../../var/cache/orm');

    $config = Setup::createConfiguration(true);
    $config->setMetadataDriverImpl($driver);
    $config->setMetadataCacheImpl($cache);
    $config->setQueryCacheImpl($cache);

	// database configuration parameters
	$conn = require_once __DIR__."/../src/Config/db.php";

	// obtaining the entity manager
	$entityManager = EntityManager::create($conn, $config);

	return $entityManager;