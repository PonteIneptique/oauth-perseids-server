<?php
	$app['swiftmailer.options'] = array();
	
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
    	),
    );