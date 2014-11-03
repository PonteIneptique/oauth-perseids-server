<?php 
	$app['security.firewalls'] = array(
			
			// Ensure that the login page is accessible to all
			'login' => array(
				'pattern' => '^/user/login$',
			),

			'api_oauth2_authorize' => array(
				'pattern' => '^/api/v1.0/oauth2/authorize$',
				'http' => true,
				'users' => $app->share(function($app) { return $app['user.manager']; }), #We reuse the stuff from SimpleUser
			),

			'oauth2_token' => array(
		        'pattern' => '^/api/v1.0/oauth2/token$',
				'oauth2_token' => $app->share(function($app) { return $app['security.authentication_provider.oauth2_token.oauth2_token']; }),
		    ),

		    'oauth2_debug' => array(
				'pattern' => '^/api/v1.0/oauth2/debug$',
				'oauth2_resource' => true,
			),
		    'api' => array(
		        'pattern' => '^/api/v1.0',
		        'oauth2_resource' => true,
		    ),
			'secured_area' => array(
				'pattern' => '^/user.*$',
				'anonymous' => true,
				'http' => true,
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