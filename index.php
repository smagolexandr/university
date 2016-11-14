<?php
/**
 * Created by PhpStorm.
 * User: smagolexandr
 * Date: 11/9/16
 * Time: 1:18 AM
 */

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/src/config/parameters.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

$connector = new Repositories\Connector(
    $configuration['database'],
    $configuration['user'],
    $configuration['password']
);

$request = Request::createFromGlobals();
$routes = include __DIR__.'/src/config/routing.php';
$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();
try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $controller = $resolver->getController($request);
    $arguments = $resolver->getArguments($request, $controller);
    $response = call_user_func_array($controller, $arguments);
} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
} catch (Exception $e) {
    $response = new Response('An error occurred', 500);
}

echo $response;
