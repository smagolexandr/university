<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

use Controllers\StudentsController;
use Controllers\DBController;
use Controllers\DefaultController;
use Controllers\UniversitiesController;

$collection = new RouteCollection();
$collection->add('index', new Route('/', array(
    '_controller' => array (new StudentsController($connector), 'indexAction'),
)));
//#################################STUDENTS#######################################
$collection->add('student_add', new Route('/student/add', array(
    '_controller' => array (new StudentsController($connector), 'newAction'),
)));

$collection->add('student_edit', new Route('/student/edit/{id}', array(
    '_controller' => array (new StudentsController($connector), 'editAction'),
)));

$collection->add('student_delete', new Route('/student/delete/{id}', array(
    '_controller' => array (new StudentsController($connector), 'deleteAction'),
)));

//#################################DB#######################################
$collection->add('db_action', new Route('/db', array(
    '_controller' => array (new DBController($connector), 'indexAction'),
)));

$collection->add('results_show', new Route('/results', array(
    '_controller' => array (new DefaultController($connector), 'resultsAction'),
)));

return $collection;