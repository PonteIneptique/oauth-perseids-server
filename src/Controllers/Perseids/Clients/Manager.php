<?php
namespace Perseids\Clients;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;
use AuthBucket\OAuth2\Entity\Clients;

class Manager implements ServiceProviderInterface, ControllerProviderInterface
{
    public function load() {
        /* Just some test stuff*/
        $model = new Client();
        $model  ->setClientId('51b2d34c3a661b5e111a694dfcb4b248')
                ->setClientSecret('237ed57f218b41d07db6757afec3a41c')
                ->setRedirectUri('http://oauthconnector.demo.drupal.authbucket.com/oauth/authorized2/1');
        $manager->persist($model);
    }
    public function register(Application $app)
    {      

    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $app->get('/clients', function(Application $app) {
            if ($app['security']->isGranted('ROLE_ADMIN')) {
                $text = "admin";
            } else {
                $text = "Not Admin";
            }
            return $text;
        })->bind('clients-list');

        return $controllers;
    }

    public function boot(Application $app)
    {
        /*$app['dispatcher']->addListener(KernelEvents::EXCEPTION, array($app['authbucket_oauth2.exception_listener'], 'onKernelException'), -8); */
    }
}
?>