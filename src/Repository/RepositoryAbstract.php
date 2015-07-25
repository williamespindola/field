<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Entity\EntityInterface;
use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;

abstract class RepositoryAbstract
{
    /**
     * @var object StorageORMInterface
     */
    protected $storage;

    public function __construct(
        $repository,
        StorageORMInterface $storage
    ) {
        $this->setStorage($storage, $repository);
    }

    /**
     * @param StorageORMInterface $storage
     * @param string $repository
     * @return RepositoryAbstract
     */
    public function setStorage(StorageORMInterface $storage, $repository)
    {
        $this->storage = $storage->setRepository($repository);

        return $this;
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @return \ArrayObject
     */
    public function findAll()
    {
        return $this->getStorage()->findAll();
    }

    /**
     * @param array $criteria
     * @param array $optimization
     * @return \ArrayObject
     */
    public function findBy(Array $criteria, array $optimization)
    {
        return $this->getStorage()->findBy($criteria, $optimization);
    }

    /**
     * @param array $criteria
     * @return EntityInterface
     */
    public function find($id)
    {
        return $this->getStorage()->find($id);
    }

    /**
     * @param EntityInterface $entity
     * @return boolean
     */
    public function save(EntityInterface $entity)
    {
        $this->getStorage()->persist($entity);
        $this->getStorage()->flush();

        return true;
    }

    /**
     * @param EntityInterface $entity
     * @return boolean
     */
    public function remove(EntityInterface $entity)
    {
        $this->getStorage()->remove($entity);
        $this->getStorage()->flush();

        return true;
    }
}
