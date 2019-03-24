<?php

namespace Application\Controller;

use Application\Entity\Job;
use Application\Entity\Teacher;
use Doctrine\ORM\Query;
use Zend\View\Model\JsonModel;

class TeacherController extends AbstractRestfulController
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
            $teacher = $query->from(Teacher::class, 't')
                ->leftJoin('t.classes', 'c')
                ->leftJoin('t.job', 'j')
                ->select('t,c,j')
                ->where('t.id = ' . $id)
                ->getQuery()
                ->getOneOrNullResult(Query::HYDRATE_ARRAY);

            if($teacher === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            $result['result'] = $teacher;

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

        $query = $em->createQueryBuilder();
        $data['result'] = $query
            ->from(Teacher::class, 't')
            ->leftJoin('t.classes', 'c')
            ->leftJoin('t.job', 'j')
            ->select('t,c,j')
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
            $teacher = new Teacher();

            if(isset($data['job']) && !empty($data['job']))
            {
                $jobId = (int)($data['job']);
                $job = $em->getRepository(Job::class)->find($jobId);

                if($job !== null)
                {
                    $teacher->setJob($job);
                }
            }

            if(isset($data['first_name']) && !empty(trim($data['first_name'])))
            {
                $teacher->setFirstName(trim($data['first_name']));
            } else {
                throw new \Exception("First name is required", 400);
            }

            if(isset($data['last_name']) && !empty(trim($data['last_name'])))
            {
                $teacher->setLastName(trim($data['last_name']));
            } else {
                throw new \Exception("Last name is required", 400);
            }

            if(isset($data['age']) && !empty(trim($data['age'])))
            {
                $teacher->setAge((int)trim($data['age']));
            } else {
                throw new \Exception("Age is required", 400);
            }

            $em->persist($teacher);
            $em->flush();

            $result['result'] = $teacher->getId();


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
            /** @var Teacher $teacher */
            $teacher = $em->getRepository(Teacher::class)->find($id);
            if($teacher === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            $em->remove($teacher);
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
            /** @var Teacher $teacher */
            $teacher = $em->getRepository(Teacher::class)->find($id);
            if($teacher === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            if(isset($data['first_name']) && !empty(trim($data['first_name'])))
            {
                $teacher->setFirstName(trim($data['first_name']));
            }

            if(isset($data['last_name']) && !empty(trim($data['last_name'])))
            {
                $teacher->setLastName(trim($data['last_name']));
            }

            if(isset($data['age']) && !empty(trim($data['age'])))
            {
                $teacher->setAge((int)trim($data['age']));
            }

            if(isset($data['job']) && !empty(trim($data['job'])))
            {
                $jobId = (int)($data['job']);
                $job = $em->getRepository(Job::class)->find($jobId);

                if($job !== null)
                {
                    $teacher->setJob($job);
                }
            }

            $em->persist($teacher);
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
}
