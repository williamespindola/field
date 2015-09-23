<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;

abstract class RepositoryAbstract
{
    abstract public function setStorage(StorageORMInterface $storage, $repository);

    abstract public function getStorage();

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
     * @return object
     */
    public function find($id)
    {
        return $this->getStorage()->find($id);
    }

    /**
     * @param Object $data
     * @return boolean
     */
    public function save($data)
    {
        $this->getStorage()->persist($data);
        $this->getStorage()->flush();

        return true;
    }

    /**
     * @param Object $entity
     * @return boolean
     */
    public function remove($entity)
    {
        $this->getStorage()->remove($entity);
        $this->getStorage()->flush();

        return true;
    }
}
