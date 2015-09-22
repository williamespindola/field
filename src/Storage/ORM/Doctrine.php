<?php

namespace WilliamEspindola\Field\Storage\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use WilliamEspindola\Field\Entity\EntityInterface;
use \InvalidArgumentException;

/**
 * Providers the Doctrine ORM
 *
 * @package WilliamEspindola\Field\Storage\ORM
 * @author William Espindola <oi@williamespindola.com.br>
 */
class Doctrine implements StorageORMInterface
{
    const INVALID_MANAGER_MESSAGE = 'Argument must be Doctrine\ORM\EntityManager';

    /**
     * @var object Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * Construct the Doctrine ORM storage with connection and mapping config
     *
     * @param array $conn
     * @param array $config
     */
    public function __construct($conn, $config)
    {
        $this->setMapper(EntityManager::create($conn, $config));
    }

    /**
     * @param object EntityManager
     * @throws \InvalidArgumentException
     */
    public function setMapper($entityManager)
    {
        if (!($entityManager instanceof EntityManager))
            throw new \InvalidArgumentException(RespectRelational::INVALID_MANAGER_MESSAGE);

        $this->entityManager = $entityManager;
    }

    /**
     * @return object Doctrine\ORM\EntityManager
     */
    public function getMapper()
    {
        return $this->entityManager;
    }

    public function getRepository()
    {
        return $this->getMapper()->getRepository($this->repository);
    }

    public function getStorage()
    {
        return $this;
    }

    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param EntityInterface $entity
     * @return boolean
     * @throws InvalidArgumentException if the param is not instance of EntityInterface
     */
    public function persist($entity)
    {
        if (!$entity instanceof EntityInterface)
            throw new Argument('The param must be instance of EntityInterface');

        return $this->getRepository()->persist($entity);
    }

    /**
     * @param EntityInterface $entity
     */
    public function remove(EntityInterface $entity)
    {
        return $this->getRepository()->remove($entity);
    }

    /**
     * @param array $criteria
     * @param array optimization
     * @return arrayObject
     */
    public function findBy(array $criteria, array $optimization)
    {
        list($order, $limit, $offset) = $optimization;

        return $this->getRepository()->findBy($criteria, $order, $limit, $offset);
    }

    /**
     * @param integer id of entity
     * @return object
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @return boolean
     */
    public function flush()
    {
        return $this->getMapper()->flush();
    }
}