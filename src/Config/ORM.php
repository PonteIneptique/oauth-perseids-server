<?php

/**
 * This file is part of the authbucket/oauth2-php package.
 *
 * (c) Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Perseids\OAuth2\Entity\ModelManagerFactory;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;


$app['db.options'] = require_once __DIR__."/db.php";

// Return an instance of Doctrine ORM entity manager.
$app['doctrine.orm.entity_manager'] = $app->share(function ($app) {
    $conn = $app['dbs']['default'];
    $em = $app['dbs.event_manager']['default'];
   
    $isDevMode = false;
    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../Entity'), $isDevMode, null, null, false);

    return EntityManager::create($conn, $config, $em);
});

// Return entity classes for model manager.
$app['authbucket_oauth2.model'] = array(
    'access_token' => 'Perseids\\OAuth2\\Entity\\AccessToken',
    'authorize' => 'Perseids\\OAuth2\\Entity\\Authorize',
    'client' => 'Perseids\\ClientsManager\\Entity\\Client',
    'code' => 'Perseids\\OAuth2\\Entity\\Code',
    'refresh_token' => 'Perseids\\OAuth2\\Entity\\RefreshToken',
    'scope' => 'Perseids\\OAuth2\\Entity\\Scope',
    'user' => 'Perseids\\OAuth2\\Entity\\User',
);

// Add model managers from ORM.
$app['authbucket_oauth2.model_manager.factory'] = $app->share(function ($app) {
    return new ModelManagerFactory(
        $app['doctrine.orm.entity_manager'],
        $app['authbucket_oauth2.model']
    );
});
