<?php 
	$app['security.firewalls'] = array(
			'api_oauth2_authorize' => array(
				'pattern' => '^/api/v1.0/oauth2/authorize$',
				#'http' => true,
				'users' => $app->share(function($app) { return $app['user.manager']; }), #We reuse the stuff from SimpleUser
			),

			'oauth2_token' => array(
		        'pattern' => '^/api/v1.0/oauth2/token$',
				'oauth2_token' => $app->share(function($app) { return $app['security.authentication_provider.oauth2_token.oauth2_token']; }),
		    ),

		    'api' => array(
		        'pattern' => '^/api/user$',
		        'oauth2_resource' => true,
		    ),

			'default' => array(
		        'pattern' => '^/',
		        'anonymous' => true,
		        'form' => array('login_path' => '/user/login', 'check_path' => '/user/login_check'),
		        'logout' => array('logout_path' => '/user/logout'),
				'users' => $app->share(function($app) { return $app['user.manager']; }),
			),

		);

   $app['security.access_rules'] = array(
        #array('^/user', 'ROLE_USER'),
        array('^/user/login$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/user/register$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/user/clients', 'ROLE_ADMIN')
    );