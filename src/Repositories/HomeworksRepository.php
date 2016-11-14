<?php
namespace Repositories;
class HomeworksRepository implements RepositoryInterface
{
    private $connector;
    /**
     * StudentsRepository constructor.
     * Initialize the database connection with sql server via given credentials
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->connector = $connector;
    }

    public function getStudentInfo($id){
        $statement = $this->connector->getPdo()->prepare('
            SELECT first_name, last_name 
            FROM students
            WHERE id = '.$id.'
        ');
        $statement->execute();
        return $statement->fetch();
    }

    public function getHomeworks($id){
        $statement = $this->connector->getPdo()->prepare('
            SELECT homeworks.done,homeworks.name AS homeworkName ,disciplines.name AS disciplineName
            FROM homeworks_students
            JOIN homeworks ON homeworks_students.homework_id = homeworks.id
            JOIN disciplines ON homeworks.discipline = disciplines.id 
            WHERE homeworks_students.student_id = '.$id.'
        ');
        $statement->execute();
        return $this->fetchHomeworksData($statement);
    }

    private function fetchHomeworksData($statement)
    {
        $results = [];
        while ($result = $statement->fetch()) {
            $results[] = [
                'name' => $result['homeworkName'],
                'discipline' => $result['disciplineName'],
                'done' => $result['done'],
            ];
        }
        return $results;
    }

    public function findAll($limit = 100, $offset = 0)
    {

    }
    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData)
    {
        // TODO: Implement insert() method.
    }
    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     */
    public function update(array $entityData)
    {
        // TODO: Implement update() method.
    }
    /**
     * Delete entity data from the DB
     * @param array $entityData
     * @return mixed
     */
    public function remove(array $entityData)
    {
        // TODO: Implement remove() method.
    }
    /**
     * Search entity data in the DB by Id
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }
    /**
     * Search all entity data in the DB like $criteria rules
     * @param array $criteria
     * @return mixed
     */
    public function findBy($criteria = [])
    {
        // TODO: Implement findBy() method.
    }
}