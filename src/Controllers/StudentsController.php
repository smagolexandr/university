<?php
namespace Controllers;
use Repositories\StudentsRepository;

class StudentsController
{
    private $repository;
    private $loader;
    private $twig;
    public function __construct($connector)
    {
        $this->repository = new StudentsRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/Students/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false, 'debug' => true
        ));
    }
    public function indexAction()
    {
        $studentsData = $this->repository->findAll();
        return $this->twig->render('show.html.twig', ['students' => $studentsData]);
    }
    public function newAction()
    {
        if (isset($_POST['first_name'])) {
            $this->repository->insert(
                [
                    'first_name' => $_POST['first_name'],
                    'last_name'  => $_POST['last_name'],
                    'email'      => $_POST['email'],
                ]
            );
            return $this->indexAction();
        }
        return $this->twig->render('form.html.twig',
            [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
            ]
        );
    }
    public function editAction($id)
    {
        if (isset($_POST['first_name'])) {
            $this->repository->update(
                [
                    'first_name' => $_POST['first_name'],
                    'last_name'  => $_POST['last_name'],
                    'email'      => $_POST['email'],
                    'id'         => (int) $id,
                ]
            );
            return $this->indexAction();
        }
        $studentData = $this->repository->find((int) $id);
        if($studentData){
        return $this->twig->render('form.html.twig',
            [
                'first_name' => $studentData['firstName'],
                'last_name' => $studentData['lastName'],
                'email' => $studentData['email'],
            ]
        );
        } else {
            return $this->indexAction();
        }
    }
    public function deleteAction($id)
    {
        if (isset($id)) {
            $id = (int) $id;
            $this->repository->remove(['id' => $id]);
            return $this->indexAction();
        }
        return $this->twig->render('delete.html.twig', array('student_id' => $_GET['id']));
    }
}