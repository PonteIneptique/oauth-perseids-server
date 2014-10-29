<?php

/**
 * This file is part of the authbucket/oauth2-php package.
 *
 * (c) Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Perseids\Entity\ModelManagerFactory;
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

    /*
        $driver = new AnnotationDriver(new AnnotationReader(), array(__DIR__.'/../Entity'));
        $cache = new FilesystemCache(__DIR__.'/../../var/cache/orm');

        $config = Setup::createConfiguration(false);
        $config->setMetadataDriverImpl($driver);
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
    */
   
    $isDevMode = false;
    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../Entity'), $isDevMode, null, null, false);

    return EntityManager::create($conn, $config, $em);
});

// Return entity classes for model manager.
$app['authbucket_oauth2.model'] = array(
    'access_token' => 'Perseids\\Entity\\AccessToken',
    'authorize' => 'Perseids\\Entity\\Authorize',
    'client' => 'Perseids\\Entity\\Client',
    'code' => 'Perseids\\Entity\\Code',
    'refresh_token' => 'Perseids\\Entity\\RefreshToken',
    'scope' => 'Perseids\\Entity\\Scope',
    'user' => 'Perseids\\Entity\\User',
);

// Add model managers from ORM.
$app['authbucket_oauth2.model_manager.factory'] = $app->share(function ($app) {
    return new ModelManagerFactory(
        $app['doctrine.orm.entity_manager'],
        $app['authbucket_oauth2.model']
    );
});
