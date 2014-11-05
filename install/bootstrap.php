<?php
	// bootstrap.php
	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;

	#~Added
	#
	require_once __DIR__ . "/../vendor/perseids/oauth2-orm-bridge/src/Entity/AbstractEntityRepository.php";
	use Perseids\Entity\AbstractEntityRepository;
	
	require_once "../vendor/autoload.php";

	$isDevMode = false;
	$config = Setup::createAnnotationMetadataConfiguration(
		array(
			/* That's Where you load the folder of all Entities */
			//__DIR__.'/../src/Entity', 
			__DIR__.'/../vendor/perseids/clients-manager/src/Entity',
			__DIR__.'/../vendor/perseids/oauth2-orm-bridge/src/Entity'
		)
	, $isDevMode, null, null, false);


	// database configuration parameters
	$conn = require_once __DIR__."/../src/config/db.php";

	// obtaining the entity manager
	$entityManager = EntityManager::create($conn, $config);

	return $entityManager;