<?php
namespace Controllers;
use Repositories\HomeworksRepository;

class HomeworksController
{
    private $repository;
    private $loader;
    private $twig;
    public function __construct($connector)
    {
        $this->repository = new HomeworksRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/Homeworks/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false
        ));
    }
    public function indexAction($id)
    {
        $homeworksData = $this->repository->getHomeworks($id);
        $studentInfo = $this->repository->getStudentInfo($id);
        return $this->twig->render('show.html.twig', [
            'homeworks' => $homeworksData,
            'student' => $studentInfo
        ]);
    }

}