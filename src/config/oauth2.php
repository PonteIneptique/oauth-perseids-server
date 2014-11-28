<?php

    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\Tools\Setup;
	use Perseids\OAuth2\Entity\ModelManagerFactory;
    use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

    // Return entity classes for model manager.
    $app['authbucket_oauth2.model'] = array(
        'access_token' => 'Perseids\\OAuth2\\Entity\\AccessToken',
        'authorize' => 'Perseids\\OAuth2\\Entity\\Authorize',
        'client' => 'Perseids\\ClientsManager\\Entity\\Client',
        'code' => 'Perseids\\OAuth2\\Entity\\Code',
        'refresh_token' => 'Perseids\\OAuth2\\Entity\\RefreshToken',
        'scope' => 'Perseids\\OAuth2\\Entity\\Scope'
    );


    $app['security.encoder.digest'] = $app->share(function ($app) {
        return new MessageDigestPasswordEncoder();
    });

    $app['doctrine.orm.entity_manager'] = $app->share(function ($app) {
        $conn = $app['dbs']['default'];
        $em = $app['dbs.event_manager']['default'];

        $isDevMode = false;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../Entity'), $isDevMode, null, null, false);

        return EntityManager::create($conn, $config, $em);
    });

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
