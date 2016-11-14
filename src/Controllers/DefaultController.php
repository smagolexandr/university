<?php

/**
 * Created by PhpStorm.
 * User: smagolexandr
 * Date: 11/9/16
 * Time: 11:18 AM
 */
namespace Controllers;

use Repositories\StudentsRepository;

class DefaultController
{
    private $repository;
    private $loader;
    private $twig;
    public function __construct($connector)
    {
        $this->repository = new StudentsRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    public function indexAction()
    {
        $studentsData = $this->repository->findAll();
        return $this->twig->render('Students/Students.html.twig', ['students' => $studentsData]);
    }

    public function resultsAction(){
        $resultsData = $this->repository->findAll();
        return $this->twig->render('Results/results.html.twig', ['results' => $resultsData ]);
    }
}