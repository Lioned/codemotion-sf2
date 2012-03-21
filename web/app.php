<?php

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/database.php';

use Codemotion\Controller\TaskController;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Router;

use Symfony\Component\Config\FileLocator;

$request = Request::createFromGlobals();

/*  ROUTING  */
$locator = new FileLocator(array(__DIR__ . '/../app/config'));

$context = new RequestContext();
$context->fromRequest($request);

$router = new Router(
    new YamlFileLoader($locator),
    "routing.yml",
    array('cache_dir' => __DIR__.'/../app/cache/routing'),
    $context
  );

$parameters = $router->match($request->getPathInfo());

$controller = new $parameters['controller'];
$action     = $parameters['action'];

/* Dependencias del controlador */
$controller->setEntityManager($em);
$controller->setTemplating($container->get('twig'));

/* Introducimos los parametros de la ruta en los atributos del objeto request */
$request->attributes->add($parameters);

$response = $controller->$action($request);

/* Enviamos el contenido */
$response->prepare($request);
$response->send();
