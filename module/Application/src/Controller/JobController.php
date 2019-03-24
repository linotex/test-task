<?php

namespace Application\Controller;

use Application\Entity\Job;
use Doctrine\ORM\Query;
use Zend\View\Model\JsonModel;

class JobController extends AbstractRestfulController
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
            $job = $query
                ->from(Job::class, 'j')
                ->leftJoin('j.teachers', 't')
                ->select('j,t')
                ->where('j.id = ' . $id)
                ->getQuery()
                ->getOneOrNullResult(Query::HYDRATE_ARRAY);

            if($job === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            $result['result'] = $job;

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
            ->from(Job::class, 'j')
            ->leftJoin('j.teachers', 't')
            ->select('j,t')
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
            $job = new Job();

            if(isset($data['name']) && !empty(trim($data['name'])))
            {
                $job->setName(trim($data['name']));
            } else {
                throw new \Exception("Name is required", 400);
            }

            $em->persist($job);
            $em->flush();

            $result['result'] = $job->getId();


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
            /** @var Job $job */
            $job = $em->getRepository(Job::class)->find($id);
            if($job === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            $em->remove($job);
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
            /** @var Job $job */
            $job = $em->getRepository(Job::class)->find($id);
            if($job === null)
            {
                throw new \Exception("Entity is not exists", 404);
            }

            if(isset($data['name']) && !empty(trim($data['name'])))
            {
                $job->setName(trim($data['name']));
            }

            $em->persist($job);
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
