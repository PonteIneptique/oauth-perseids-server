<?php	
	$app = new Silex\Application(); 

	$app->register(new Silex\Provider\SecurityServiceProvider(), array(
	    'security.firewalls' => array(
			
			// Ensure that the login page is accessible to all
			'login' => array(
			'pattern' => '^/user/login$',
			),
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
			'oauth2_authorize' => array(
				'pattern' => '^/rest/oauth2/authorize$',
				'http' => true,
				'users' => $app->share(function($app) { return $app['user.manager']; }), #We reuse the stuff from SimpleUser
			),
			'oauth2_token' => array(
		        'pattern' => '^/rest/oauth2/token$',
		        'oauth2_token' => true,
		    ),
		    'oauth2_debug' => array(
				'pattern' => '^/rest/oauth2/debug$',
				'oauth2_resource' => true,
			),
		)
	));

	/* Register needed by authbucket oauth-2 */
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
		'db.options' => require_once __DIR__."/Config/db.php",
	));


	/* SimpleUser Instance */
	$simpleUserProvider = new SimpleUser\UserServiceProvider();
	$app->register($simpleUserProvider);

	//$app["security.authentication_providers"] = array($app['user.manager']);

	/* oAuth2 Instance*/
	$clients = new Perseids\ClientsManager\ClientServiceProvider($app);
	$app->register($clients);

	/* oAuth2 Instance*/
	$AuthBucket = new AuthBucket\OAuth2\Provider\AuthBucketOAuth2ServiceProvider();
	$app->register($AuthBucket);

	$oAuth = new Perseids\OAuth2\OAuth2ServiceProvider($app, $app['user.manager']);
	$app->register($oAuth);
	


	/* Debug Mode */
	$app['debug'] = true;

	/* Routes */
	$app->mount('/api/oauth2', $oAuth);
	$app->mount('/clients', $clients);
	$app->mount('/user', $simpleUserProvider);

	$app->get('/', function () use ($app) {
	    return $app['twig']->render('index.twig', array());
	});
/*
	if($app["security"]->getToken()) {
		exit();	
	}*/
	/* TWIG Configuration */
	$app['twig.path'] = array(__DIR__.'/../templates');
	$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

	/* DATABASE CONFIGURATOR */

	// Mailer config. See http://silex.sensiolabs.org/doc/providers/swiftmailer.html
	$app['swiftmailer.options'] = array();

	$app['security.access_rules'] = array(
	    array('^/clients', 'ROLE_ADMIN', 'http'),
	    array('^.*$', 'ROLE_USER'),/**/
	);

	$app['user.passwordStrengthValidator'] = $app->protect(function(SimpleUser\User $user, $password) {
		if (strlen($password) < 4) {
			return 'Password must be at least 4 characters long.';
		}
		if (strtolower($password) == strtolower($user->getName())) {
			return 'Your password cannot be the same as your name.';
		}
	});


	$app['user.options'] = array(
    	// Specify custom view templates here.
    	'templates' => array(
    		//Setting the General Layout
    		'layout' => "layout.twig"
    	)
    );

	return $app;
?>