<?php

namespace Application\Controller;

use Application\Entity\Classes;
use Application\Entity\Student;
use Doctrine\ORM\Query;
use Zend\View\Model\JsonModel;

class StudentController extends AbstractRestfulController
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
            $student = $query
                ->from(Student::class, 's')
                ->leftJoin('s.classes', 'c')
                ->select('s,c')
                ->where('s.id = ' . $id)
                ->getQuery()
                ->getOneOrNullResult(Query::HYDRATE_ARRAY);

            if($student === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            $result['result'] = $student;

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
            ->from(Student::class, 's')
            ->leftJoin('s.classes', 'c')
            ->select('s,c');

        if(!empty($group))
        {
            $query->andWhere('s.group = :group')
                ->setParameter('group', $group, \PDO::PARAM_INT);
        }

        $data['result'] = $query
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
            $student = new Student();

            if(isset($data['first_name']) && !empty(trim($data['first_name'])))
            {
                $student->setFirstName(trim($data['first_name']));
            } else {
                throw new \Exception("First name is required", 400);
            }

            if(isset($data['last_name']) && !empty(trim($data['last_name'])))
            {
                $student->setLastName(trim($data['last_name']));
            } else {
                throw new \Exception("Last name is required", 400);
            }

            if(isset($data['group']) && !empty(trim($data['group'])))
            {
                $student->setGroup((int)trim($data['group']));
            } else {
                throw new \Exception("Group is required", 400);
            }

            $em->persist($student);
            $em->flush();

            $result['result'] = $student->getId();


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
            /** @var Student $student */
            $student = $em->getRepository(Student::class)->find($id);
            if($student === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            if($this->params('sub') !== null)
            {
                $classes = $this->getClasses();
                $student->removeClasses($classes);
            }

            $em->remove($student);
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
            /** @var Student $student */
            $student = $em->getRepository(Student::class)->find($id);
            if($student === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            if($this->params('sub') !== null)
            {
                $classes = $this->getClasses();

                if(!$student->classesIsAdded($classes))
                {
                    $student->addClasses($classes);
                }
            }

            if(isset($data['first_name']) && !empty(trim($data['first_name'])))
            {
                $student->setFirstName(trim($data['first_name']));
            }

            if(isset($data['last_name']) && !empty(trim($data['last_name'])))
            {
                $student->setLastName(trim($data['last_name']));
            }

            if(isset($data['group']) && !empty(trim($data['group'])))
            {
                $student->setLastName((int)trim($data['last_name']));
            }

            $em->persist($student);
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

    private function getClasses()
    {
        if(empty($this->params('sub_id')))
        {
            throw new \Exception('Entity id is required', 400);
        }

        $classes = $this->getEntityManager()->getRepository(Classes::class)->find((int)$this->params('sub_id'));

        if($classes === null)
        {
            throw new \Exception("Entity is not exists", 404);
        }

        return $classes;
    }
}
