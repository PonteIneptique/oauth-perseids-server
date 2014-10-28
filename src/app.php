<?php
	$app = new Silex\Application(); 
	
	/* Register needed by authbucket oauth-2 */
	$app->register(new AuthBucket\OAuth2\Provider\AuthBucketOAuth2ServiceProvider());
	$app->register(new Silex\Provider\SecurityServiceProvider());
	$app->register(new Silex\Provider\SerializerServiceProvider());
	$app->register(new Silex\Provider\ServiceControllerServiceProvider());
	$app->register(new Silex\Provider\ValidatorServiceProvider());

	/*Register Needed by SimpleUser*/
	$app->register(new Silex\Provider\DoctrineServiceProvider());
	$app->register(new Silex\Provider\SecurityServiceProvider());
	$app->register(new Silex\Provider\RememberMeServiceProvider());
	$app->register(new Silex\Provider\SessionServiceProvider());
	$app->register(new Silex\Provider\ServiceControllerServiceProvider());
	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
	$app->register(new Silex\Provider\TwigServiceProvider());
	$app->register(new Silex\Provider\SwiftmailerServiceProvider());

	$simpleUserProvider = new SimpleUser\UserServiceProvider();
	$app->register($simpleUserProvider);


	/* Debug Mode */
	$app['debug'] = true;

	/* Routes */
	$app->mount('/user', $simpleUserProvider);

	$app->get('/', function () use ($app) {
	    return $app['twig']->render('index.twig', array());
	});

	$app['user.options'] = array();

	/* TWIG Configuration */
	$app['twig.path'] = array(__DIR__.'/../templates');
	$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

	/* DATABASE CONFIGURATOR */
	$app['db.options'] = array(
		'driver' => 'pdo_mysql',
		'host' => 'localhost',
		'dbname' => 'oAuthServer',
		'user' => 'perseids',
		'password' => 'perseids',
	);

	// Mailer config. See http://silex.sensiolabs.org/doc/providers/swiftmailer.html
	$app['swiftmailer.options'] = array();

	/* Firewall configuration */
	$app['security.firewalls'] = array(
		/*
		// Ensure that the login page is accessible to all
		'login' => array(
		'pattern' => '^/user/login$',
		),*/
		'secured_area' => array(
			'pattern' => '^.*$',
			'anonymous' => true,
			'remember_me' => array(),
			'form' => array(
				'login_path' => '/user/login',
				'check_path' => '/user/login_check',
			),
			'logout' => array(
				'logout_path' => '/user/logout',
			),
			'users' => $app->share(function($app) { return $app['user.manager']; }),
		),
	);

	return $app;
?>