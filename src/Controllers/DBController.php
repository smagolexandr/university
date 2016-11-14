<?php
namespace Controllers;
use Repositories\DBRepository;

class DBController
{
    private $repository;
    private $loader;
    private $twig;
    public function __construct($connector)
    {
        $this->repository = new DBRepository($connector);
    }
    public function indexAction(){
        $this->repository->StudentsCreate();
        $this->repository->UniversitiesCreate();
        $this->repository->KafedrasCreate();
        $this->repository->TeachersCreate();
        $this->repository->TeachersDisciplinesCreate();
        $this->repository->DisciplinesCreate();
        $this->repository->HomeworksCreate();
        $this->repository->HomeworksStudentsCreate();
        for ($i=0; $i < 30; $i++) {
            $this->repository->StudentLoad();
            $this->repository->UniversityLoad();
            $this->repository->KafedraLoad();
            $this->repository->TeacherLoad();
            $this->repository->DisciplineLoad();
            $this->repository->HomeworkLoad();
        }
        for ($i=0; $i < 100; $i++) {
            $this->repository->TeacherDisciplineLoad();
            $this->repository->HomeworkStudentLoad();
        }
        echo "fixtures loaded";
        return true;
    }
}