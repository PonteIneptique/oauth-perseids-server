<?php
namespace Perseids\Clients;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;
use AuthBucket\OAuth2\Entity\Clients;
use AuthBucket\OAuth2\Model\InMemory\ModelManagerFactory;

class Manager implements ServiceProviderInterface, ControllerProviderInterface
{
    /** @var ClientManager */
    protected $clientManager;
    protected $modelManagerFactory;

    /**
     * [__construct description]
     * @param ModelManagerFactoryInterface $modelManagerFactory [description]
     */
    public function __construct(ModelManagerFactory $modelManagerFactory = null)
    {
        if($modelManagerFactory === null) {
            $modelManagerFactory = new ModelManagerInterface();
        }
        $this->modelManagerFactory = $modelManagerFactory;
    }

    public function register(Application $app) {      

    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $app->before(function () use ($app) {
            $app['twig']->addGlobal('layout', null);
            $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
        });

        $app->get('/clients', function(Application $app) {

            $clientManager = $this->modelManagerFactory->getModelManager('client');
            $users = $this->clientManager->findBy($criteria, array(
                'limit' => array($offset, $limit),
                'order_by' => array($order_by, $order_dir),
            ));
            $numResults = $this->clientManager->findCount($criteria);

            $paginator = new Paginator($numResults, $limit, $page,
                $app['url_generator']->generate('user.list') . '?page=(:num)&limit=' . $limit . '&order_by=' . $order_by . '&order_dir=' . $order_dir
            );

            return $clients;
            return $app['twig']->render('Clients/list.twig', array(
                "clients" => $clientsList,
                "paginator" => $paginator
            ));
        })->bind('clients-list');

        return $controllers;
    }

    public function boot(Application $app)
    {
        /*$app['dispatcher']->addListener(KernelEvents::EXCEPTION, array($app['authbucket_oauth2.exception_listener'], 'onKernelException'), -8); */
    }
}
?>