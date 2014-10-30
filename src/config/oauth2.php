<?php

	use Perseids\OAuth2\Entity\ModelManagerFactory;

    // Return entity classes for model manager.
    $app['authbucket_oauth2.model'] = array(
        'access_token' => 'Perseids\\OAuth2\\Entity\\AccessToken',
        'authorize' => 'Perseids\\OAuth2\\Entity\\Authorize',
        'client' => 'Perseids\\ClientsManager\\Entity\\Client',
        'code' => 'Perseids\\OAuth2\\Entity\\Code',
        'refresh_token' => 'Perseids\\OAuth2\\Entity\\RefreshToken',
        'scope' => 'Perseids\\OAuth2\\Entity\\Scope'
    );

    // Add model managers from ORM.
    $app['authbucket_oauth2.model_manager.factory'] = $app->share(function ($app) {
        return new ModelManagerFactory(
            $app['doctrine.orm.entity_manager'],
            $app['authbucket_oauth2.model']
        );
    });


    $app['security.user_provider.default'] = $app->share(function ($app) {
        return $app['user.manager'];
    });
