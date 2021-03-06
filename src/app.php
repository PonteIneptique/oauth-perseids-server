<?php	
	$app = new Silex\Application(); 

	$app->register(new Silex\Provider\SecurityServiceProvider());

	/*
	
	Register needed by authbucket oauth-2 */
	$app->register(new Silex\Provider\TranslationServiceProvider()) ;
	$app->register(new Silex\Provider\FormServiceProvider());
	$app->register(new Silex\Provider\SerializerServiceProvider());
	$app->register(new Silex\Provider\ServiceControllerServiceProvider());
	$app->register(new Silex\Provider\ValidatorServiceProvider());

	/*Register Needed by SimpleUser*/
	$app->register(new Silex\Provider\DoctrineServiceProvider());
	$app->register(new Silex\Provider\RememberMeServiceProvider());
	$app->register(new Silex\Provider\SessionServiceProvider());
	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
	$app->register(new Silex\Provider\TwigServiceProvider());
	$app->register(new Silex\Provider\SwiftmailerServiceProvider());


	$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
		'db.options' => require_once __DIR__."/config/db.php",
	));


	/* SimpleUser Instance */
	$simpleUserProvider = new SimpleUser\UserServiceProvider();
	$app->register($simpleUserProvider);

	/* oAuth2 Instance*/
	$clients = new Perseids\ClientsManager\ClientServiceProvider($app);
	$app->register($clients);

	/* oAuth2 Instance*/
	$AuthBucket = new Perseids\OAuth2\OAuth2ServiceProvider();
	$app->register($AuthBucket);

	/* oAuth2 Authorize Implementation with Form */
	$authorize = new Perseids\OAuth2\OAuth2Authorize($app);
	$app->register($authorize);

	$PerseidsAPI= new Perseids\OAuth2\API($app);
	$app->register($PerseidsAPI);

	/* Debug Mode */
	#$app['debug'] = true;

	/* Routes */
	$app->mount('/api/oauth2', $AuthBucket);
	$app->mount('/api/', $PerseidsAPI);
	$app->mount('/user/clients', $clients);
	$app->mount('/user', $simpleUserProvider);
	$app->mount('/user', $authorize);
	require_once(__DIR__ . "/config/additional_routes.php");

	/* TWIG Configuration */
	$app['twig.path'] = array(__DIR__.'/../templates');
	$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

	$app['swiftmailer.options'] = array();
	
	require_once __DIR__ . "/config/security.php";
	require_once(__DIR__ . "/config/user.php");
	require_once(__DIR__ . "/config/oauth2.php");

	return $app; 
?>