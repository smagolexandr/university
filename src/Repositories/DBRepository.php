<?php
namespace Repositories;

use Faker\Factory;
class DBRepository implements RepositoryInterface
{
    private $connector;
    /**
     * StudentsRepository constructor.
     * Initialize the database connection with sql server via given credentials
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->faker = Factory::create();
        $this->connector = $connector;
    }

    public function StudentsCreate(){
        $statement = $this->connector->getPdo()->prepare('CREATE TABLE students (
                                                          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                          first_name CHAR (30),
                                                          last_name CHAR (30),
                                                          email char(60),
                                                          kafedra INT NOT NULL
                                                        ) ENGINE=INNODB charset=utf8;');
        return $statement->execute();
    }

    public function StudentLoad(){
        $statement = $this->connector->getPdo()->prepare('INSERT INTO students (first_name,last_name,email,kafedra)
                                                          VALUES (:first_name,:last_name,:email,:kafedra);');
        $statement->bindValue(':first_name', $this->faker->firstName);
        $statement->bindValue(':last_name', $this->faker->lastName);
        $statement->bindValue(':email', $this->faker->email);
        $statement->bindValue(':kafedra', $this->faker->numberBetween($min = 1, $max = 30));
        return $statement->execute();
    }

    public function UniversitiesCreate(){
        $statement = $this->connector->getPdo()->prepare('CREATE TABLE universities (
                                                          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                          name CHAR (30),
                                                          city CHAR (50),
                                                          url CHAR(50)
                                                        ) ENGINE=INNODB charset=utf8;');
        return $statement->execute();
    }

    public function UniversityLoad(){
        $statement = $this->connector->getPdo()->prepare('INSERT INTO universities (name,city,url)
                                                          VALUES (:name,:city,:url)');
        $statement->bindValue(':name', $this->faker->unique()->company);
        $statement->bindValue(':city', $this->faker->city);
        $statement->bindValue(':url',  $this->faker->url);
        return $statement->execute();
    }

    public function KafedrasCreate(){
        $statement = $this->connector->getPdo()->prepare('CREATE TABLE kafedras (
                                                          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                          name CHAR (30),
                                                          university INT NOT NULL
                                                        ) ENGINE=INNODB charset=utf8;');
        return $statement->execute();
    }

    public function KafedraLoad(){
        $statement = $this->connector->getPdo()->prepare('INSERT INTO kafedras (name, university)
                                                          VALUES (:name,:university);');
        $statement->bindValue(':name', $this->faker->unique()->word);
        $statement->bindValue(':university', $this->faker->numberBetween($min = 1, $max = 30));
        return $statement->execute();
    }

    public function TeachersCreate(){
        $statement = $this->connector->getPdo()->prepare('CREATE TABLE teachers (
                                                          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                          first_name CHAR (30),
                                                          last_name CHAR (30),
                                                          kafedra INT NOT NULL
                                                        ) ENGINE=INNODB charset=utf8;');
        return $statement->execute();
    }

    public function TeacherLoad(){
        $statement = $this->connector->getPdo()->prepare('INSERT INTO teachers (first_name,last_name,kafedra)
                                                          VALUES (:first_name,:last_name,:kafedra);');
        $statement->bindValue(':first_name', $this->faker->firstName);
        $statement->bindValue(':last_name', $this->faker->lastName);
        $statement->bindValue(':kafedra', $this->faker->numberBetween($min = 1, $max = 30));
        return $statement->execute();
    }
    public function DisciplinesCreate(){
        $statement = $this->connector->getPdo()->prepare('CREATE TABLE disciplines (
                                                          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                          name CHAR (30),
                                                          kafedra INT NOT NULL
                                                        ) ENGINE=INNODB charset=utf8;');
        return $statement->execute();
    }

    public function DisciplineLoad(){
        $statement = $this->connector->getPdo()->prepare('INSERT INTO disciplines (name,kafedra)
                                                          VALUES (:name,:kafedra);');
        $statement->bindValue(':name', $this->faker->unique()->word);
        $statement->bindValue(':kafedra', $this->faker->numberBetween($min = 1, $max = 30));
        return $statement->execute();
    }

    public function TeachersDisciplinesCreate(){
        $statement = $this->connector->getPdo()->prepare('CREATE TABLE teachers_disciplines (
                                                          teachers_id INT NOT NULL ,
                                                          disciplines_id INT NOT NULL ,
                                                          PRIMARY KEY (teachers_id, disciplines_id), 
                                                          FOREIGN KEY (teachers_id) REFERENCES teachers(id) ON UPDATE CASCADE,
                                                          FOREIGN KEY (disciplines_id) REFERENCES disciplines(id) ON UPDATE CASCADE
                                                        ) ENGINE=INNODB charset=utf8;');
        return $statement->execute();
    }

    public function TeacherDisciplineLoad(){
        $statement = $this->connector->getPdo()->prepare('INSERT INTO teachers_disciplines (teachers_id,disciplines_id)
                                                          VALUES (:name,:kafedra);');
        $statement->bindValue(':teachers_id', $this->faker->numberBetween($min = 1, $max = 30));
        $statement->bindValue(':disciplines_id', $this->faker->numberBetween($min = 1, $max = 30));
        return $statement->execute();
    }


    public function HomeworksCreate(){
        $statement = $this->connector->getPdo()->prepare('CREATE TABLE homeworks (
                                                          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                          name CHAR (30),
                                                          discipline INT NOT NULL,
                                                          done BOOLEAN NOT NULL DEFAULT false
                                                        ) ENGINE=INNODB charset=utf8;');
        return $statement->execute();
    }

    public function HomeworkLoad(){
        $statement = $this->connector->getPdo()->prepare('INSERT INTO homeworks (name,discipline,done)
                                                          VALUES (:name,:discipline,:done);');
        $statement->bindValue(':name', $this->faker->unique()->word);
        $statement->bindValue(':discipline', $this->faker->numberBetween($min = 1, $max = 30));
        $statement->bindValue(':done', $this->faker->boolean);
        return $statement->execute();
    }

    public function HomeworksStudentsCreate(){
        $statement = $this->connector->getPdo()->prepare('CREATE TABLE homeworks_students (
                                                          homework_id INT NOT NULL,
                                                          student_id INT NOT NULL,
                                                          PRIMARY KEY (homework_id, student_id), 
                                                          FOREIGN KEY (homework_id) REFERENCES homeworks(id) ON UPDATE CASCADE,
                                                          FOREIGN KEY (student_id) REFERENCES students(id) ON UPDATE CASCADE
                                                        ) ENGINE=INNODB charset=utf8;');
        return $statement->execute();
    }

    public function HomeworkStudentLoad(){
        $statement = $this->connector->getPdo()->prepare('INSERT INTO homeworks_students (homework_id,student_id)
                                                          VALUES (:homework_id,:student_id);');
        $statement->bindValue(':homework_id', $this->faker->numberBetween($min = 1, $max = 30));
        $statement->bindValue(':student_id',  $this->faker->numberBetween($min = 1, $max = 30));
        return $statement->execute();
    }

    public function findAll($limit = 250, $offset = 0)
    {

    }

    public function insert(array $studentData)
    {

    }
    public function find($id)
    {

    }
    public function update(array $studentData)
    {

    }
    public function remove(array $studentData)
    {

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