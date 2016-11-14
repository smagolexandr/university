<?php
namespace Controllers;
use Repositories\UniversitiesRepository;

class UniversitiesController
{
    private $repository;
    private $loader;
    private $twig;
    public function __construct($connector)
    {
        $this->repository = new UniversitiesRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/Universities/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }
    public function indexAction()
    {
        $universitiesData = $this->repository->findAll();
        return $this->twig->render('show.html.twig', ['universities' => $universitiesData]);
    }
    public function newAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->insert(
                [
                    'name' => $_POST['name'],
                    'city' => $_POST['city'],
                    'url'  => $_POST['url'],
                ]
            );
            return $this->indexAction();
        }
        return $this->twig->render('form.html.twig',
            [
                'first_name' => '',
                'city' => '',
                'email' => '',
            ]
        );
    }
    public function editAction($id)
    {
        if (isset($_POST['name'])) {
            $this->repository->update(
                [
                    'name' => $_POST['name'],
                    'city' => $_POST['city'],
                    'url'  => $_POST['url'],
                    'id'   => (int) $id,
                ]
            );
            return $this->indexAction();
        }
        $universitiesData = $this->repository->find((int) $id);
        if($universitiesData){
            return $this->twig->render('form.html.twig',
                [
                    'name' => $universitiesData['name'],
                    'city' => $universitiesData['city'],
                    'url' => $universitiesData['url'],
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
        return $this->twig->render('delete.html.twig', array('university_id' => $id));
    }
}