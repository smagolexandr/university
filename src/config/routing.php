<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Controllers\StudentsController;
use Controllers\DefaultController;

$collection = new RouteCollection();
$collection->add('index', new Route('/', array(
    '_controller' => array (new StudentsController($connector), 'indexAction'),
)));

$collection->add('student_add', new Route('/student/add', array(
    '_controller' => array (new StudentsController($connector), 'newAction'),
)));

$collection->add('student_edit', new Route('/student/edit', array(
    '_controller' => array (new StudentsController($connector), 'editAction'),
)));

$collection->add('student_delete', new Route('/student/delete', array(
    '_controller' => array (new StudentsController($connector), 'deleteAction'),
)));

$collection->add('results_show', new Route('/results', array(
    '_controller' => array (new DefaultController($connector), 'resultsAction'),
)));

return $collection;