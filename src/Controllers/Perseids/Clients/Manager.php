<?php
namespace Perseids\Clients;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\DisabledException;

use AuthBucket\OAuth2\Entity\Clients;
use JasonGrimes\Paginator;

use Perseids\Entity\ModelManagerFactory;
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
        $this->modelManagerFactory = $modelManagerFactory;
        $this->clientManager = $this->modelManagerFactory->getModelManager('client');
    }

    public function register(Application $app) {      
        $app->before(function () use ($app) {
            $app['twig']->addGlobal('layout', null);
            $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
        });
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $app->get('/clients', function(Application $app, Request $request) {
            $order_by = $request->get('order_by') ?: 'clientId';
            $order_dir = $request->get('order_dir') == 'DESC' ? 'DESC' : 'ASC';
            $limit = (int)($request->get('limit') ?: 50);
            $page = (int)($request->get('page') ?: 1);
            $offset = ($page - 1) * $limit;
            $criteria = array();

            # public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
            $clients = $this->clientManager->findBy(
                $criteria, 
                array(  //Order Array => array(fieldname, direction)
                    $order_by => $order_dir
                ),
                $limit,
                $offset
            );
            $numResults = $this->clientManager->findCount($criteria);

            $paginator = new Paginator($numResults, $limit, $page,
                $app['url_generator']->generate('user.list') . '?page=(:num)&limit=' . $limit . '&order_by=' . $order_by . '&order_dir=' . $order_dir
            );

            return $app['twig']->render('Clients/list.twig', array(
                "clients" => $clients,
                "paginator" => $paginator
            ));
        })->bind('clients.list');

        $app->get('/clients/edit/{id}', function(Application $app, Request $request, $id) {

            $criteria = array("id" => $id);
            $client = $this->clientManager->findOneBy(
                $criteria
            );

            return $app['twig']->render('Clients/edit.twig', array(
                "client" => $client
            ));
        })->bind('clients.edit');

        return $controllers;
    }

    public function boot(Application $app) {
    }
}
?>