<?php
/**
	 * Bootstrap for database migration.
	 *
	 * See https://github.com/jasongrimes/silex-simpleuser/edit/master/sql/MIGRATION.md
	 */

	require __DIR__ . '/../vendor/autoload.php';

	// Set up the Doctrine DBAL Connection.
	// (The database user must have permission to ALTER the tables.)
	$app = new Silex\Application();
	$app->register(new Silex\Provider\DoctrineServiceProvider());

	// Get $app['db.options'] from your config file, if you have one, something like this: 
	// require __DIR__ . '/../config/local.php';

	// Or, define $app['db.options'] explicitly:
	$app['db.options'] =  require_once __DIR__ . "/../src/config/db.php";

	// Instantiate the migration class.
	// (If you're using custom table names for the "users" and "user_custom_fields" tables,
	// pass them as the optional second and third constructor arguments.)
	$migrate = new SimpleUser\Migration\MigrateV1ToV2($app['db']);