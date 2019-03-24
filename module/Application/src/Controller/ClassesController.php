<?php

namespace Application\Controller;

use Application\Entity\Classes;
use Application\Entity\Student;
use Application\Entity\Teacher;
use Doctrine\ORM\Query;
use Zend\View\Model\JsonModel;

class ClassesController extends AbstractRestfulController
{
    public function get($id)
    {
        $em = $this->getEntityManager();
        $result = [
            'status' => 200,
            'message' => null,
            'result' => null
        ];
        try {

            $query = $em->createQueryBuilder();
            $classes = $query
                ->from(Classes::class, 'g')
                ->select('g,t,s')
                ->leftJoin('g.teacher', 't')
                ->leftJoin('g.students', 's')
                ->where('g.id = ' . $id)
                ->getQuery()
                ->getOneOrNullResult(Query::HYDRATE_ARRAY);

            if($classes === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            $result['result'] = $classes;

        } catch (\Exception $e) {
            $result['status'] = $e->getCode();
            $result['message'] = $e->getMessage();

            if($e->getCode() !== 0)
            {
                $this->response->setStatusCode($e->getCode());
            }
        }

        return new JsonModel($result);
    }

    public function getList()
    {
        $em = $this->getEntityManager();
        $data = [
            'status' => 200,
            'message' => null,
            'result' => null
        ];

        $group = $this->params()->fromQuery('group', null);

        $query = $em->createQueryBuilder();
        $query
            ->from(Classes::class, 'c')
            ->leftJoin('c.teacher', 't')
            ->leftJoin('c.students', 's')
            ->select('c,t');

        if(!empty($group))
        {
            $query
                ->addGroupBy('c.id')
                ->andWhere('s.group = :group')
                ->setParameter('group', $group, \PDO::PARAM_INT);
        } else {
            $query->addSelect('s');
        }

        $data['result']  = $query
            ->getQuery()
            ->getArrayResult();

        return new JsonModel($data);
    }

    public function create($data)
    {
        $em = $this->getEntityManager();
        $result = [
            'status' => 201,
            'message' => null,
            'result' => null
        ];

        try
        {
            $classes = new Classes();

            if(isset($data['teacher']) && !empty(trim($data['teacher'])))
            {
                $teacherId = (int)$data['teacher'];
                $teacher = $em->getRepository(Teacher::class)->find($teacherId);

                if($teacher !== null)
                {
                    $classes->setTeacher($teacher);
                }
            }

            if(isset($data['name']) && !empty(trim($data['name'])))
            {
                $classes->setName(trim($data['name']));
            } else {
                throw new \Exception("Name is required", 400);
            }

            if(isset($data['day']) && !empty(trim($data['day'])))
            {
                $classes->setDay((int)trim($data['day']));
            } else {
                throw new \Exception("Day is required", 400);
            }

            if(isset($data['room']) && !empty(trim($data['room'])))
            {
                $classes->setRoom((int)trim($data['room']));
            } else {
                throw new \Exception("Room is required", 400);
            }

            if(isset($data['start_hour']) && !empty(trim($data['start_hour'])))
            {
                $classes->setStartHour((int)trim($data['start_hour']));
            } else {
                throw new \Exception("Start hour is required", 400);
            }

            $em->persist($classes);
            $em->flush();

            $result['result'] = $classes->getId();


        } catch (\Exception $e) {
            $result['status'] = $e->getCode();
            $result['message'] = $e->getMessage();

            if($e->getCode() !== 0)
            {
                $this->response->setStatusCode($e->getCode());
            }
        }

        return new JsonModel($result);
    }

    public function delete($id)
    {
        $em = $this->getEntityManager();
        $result = [
            'status' => 204,
            'message' => null,
            'result' => null
        ];

        try
        {
            /** @var Classes $classes */
            $classes = $em->getRepository(Classes::class)->find($id);
            if($classes === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            if($this->params('sub') !== null)
            {
                $student = $this->getStudent();
                $classes->removeStudent($student);
            }

            $em->remove($classes);
            $em->flush();


        } catch (\Exception $e) {
            $result['status'] = $e->getCode();
            $result['message'] = $e->getMessage();

            if($e->getCode() !== 0)
            {
                $this->response->setStatusCode($e->getCode());
            }
        }

        return new JsonModel($result);
    }

    public function update($id, $data)
    {
        $em = $this->getEntityManager();
        $result = [
            'status' => 204,
            'message' => null,
            'result' => null
        ];

        try
        {
            /** @var Classes $classes */
            $classes = $em->getRepository(Classes::class)->find($id);
            if($classes === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            if($this->params('sub') !== null)
            {
                $student = $this->getStudent();

                if(!$classes->studentIsAdded($student))
                {
                    $classes->addStudent($student);
                }
            }

            if(isset($classes['name']) && !empty(trim($data['name'])))
            {
                $classes->setName(trim($data['name']));
            }

            if(isset($data['day']) && !empty(trim($data['day'])))
            {
                $classes->setDay((int)trim($data['day']));
            }

            if(isset($data['room']) && !empty(trim($data['room'])))
            {
                $classes->setRoom((int)trim($data['room']));
            }

            if(isset($data['start_hour']) && !empty(trim($data['start_hour'])))
            {
                $classes->setStartHour((int)trim($data['start_hour']));
            }

            if(isset($data['teacher']) && !empty(trim($data['teacher'])))
            {
                $teacherId = (int)$data['teacher'];
                $teacher = $em->getRepository(Teacher::class)->find($teacherId);

                if($teacher !== null)
                {
                    $classes->setTeacher($teacher);
                }
            }

            $em->persist($classes);
            $em->flush();


        } catch (\Exception $e) {
            $result['status'] = $e->getCode();
            $result['message'] = $e->getMessage();

            if($e->getCode() !== 0)
            {
                $this->response->setStatusCode($e->getCode());
            }
        }

        return new JsonModel($result);
    }

    private function getStudent()
    {
        if(empty($this->params('sub_id')))
        {
            throw new \Exception('Entity id is required', 400);
        }

        $student = $this->getEntityManager()->getRepository(Student::class)->find((int)$this->params('sub_id'));

        if($student === null)
        {
            throw new \Exception("Entity is not exists", 404);
        }

        return $student;
    }
}
