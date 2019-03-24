<?php

namespace Application\Controller;

use Zend\Mvc;
use Interop\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;

class AbstractRestfulController extends Mvc\Controller\AbstractRestfulController
{
    const DEFAULT_RESULT_LIMIT = 10;

    protected $container;

    protected $entityManager;

    public function __construct(ContainerInterface $container, array $options = null)
    {
        $this->container = $container;

        if ($container->has('doctrine.entitymanager.orm_default')) {
            $this->setEntityManager($container->get('doctrine.entitymanager.orm_default'));
        }
    }

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Delete the entire resource collection
     *
     * Not marked as abstract, as that would introduce a BC break
     * (introduced in 2.1.0); instead, raises an exception if not implemented.
     *
     * @return mixed
     */
    public function deleteList($data)
    {
        $this->response->setStatusCode(405);

        return new JsonModel([
            'message' => 'Method Not Allowed'
        ]);
    }

    public function head($id = null)
    {
        $this->response->setStatusCode(405);

        return new JsonModel([
            'message' => 'Method Not Allowed'
        ]);
    }

    public function options()
    {
        $this->response->setStatusCode(405);

        return new JsonModel([
            'message' => 'Method Not Allowed'
        ]);
    }

    public function patch($id, $data)
    {
        $this->response->setStatusCode(405);

        return new JsonModel([
            'message' => 'Method Not Allowed'
        ]);
    }

    public function replaceList($data)
    {
        $this->response->setStatusCode(405);

        return new JsonModel([
            'message' => 'Method Not Allowed'
        ]);
    }

    public function patchList($data)
    {
        $this->response->setStatusCode(405);

        return new JsonModel([
            'message' => 'Method Not Allowed'
        ]);
    }
}
