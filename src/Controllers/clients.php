<?php

/**
 * Original headers :
 *
 * 
 * This file is part of the authbucket/oauth2-php package.
 *
 * (c) Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perseids;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;

/**
 * OAuth2 service provider as plugin for Silex SecurityServiceProvider.
 *
 * @author Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 */
class Clients implements ServiceProviderInterface, ControllerProviderInterface
{
    public function register(Application $app)
    {     
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $app->get('/clients', function() {
            return "Placeholder";
        })->bind('clients-list');

        return $controllers;
    }

    public function boot(Application $app)
    {
        /*$app['dispatcher']->addListener(KernelEvents::EXCEPTION, array($app['authbucket_oauth2.exception_listener'], 'onKernelException'), -8); */
    }
}
?>