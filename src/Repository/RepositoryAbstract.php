<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Entity\EntityInterface;
use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;
use Respect\Relational\Sql;
use GeneratedHydrator\Configuration;

abstract class RepositoryAbstract
{
    const INVALID_TABEL_NAME_MESSAGE = 'Invalid table name %s.';

    /**
     * @var string $tableName
     */
    private $tableName;

    /**
     * @var object WilliamEspindola\Article\Entity\EntityInterface
     */
    protected $entity;

    /**
     * @var object WilliamEspindola\Article\Storage\ORM\StorageORMInterface
     */
    protected $storage;

    public function __construct(
        $tableName,
        EntityInterface $entity,
        StorageORMInterface $storage
    ) {
        $this->setTableName($tableName);
        $this->setEntity($entity);
        $this->setStorage($storage);
    }

    /**
     * @param string $tableName
     * @throws \InvalidArgumentException
     * @return RepositoryInterface
     */
    public function setTableName($tableName)
    {
        if (!is_string($tableName)) {
            throw new \InvalidArgumentException(sprintf(
                RepositoryAbstract::INVALID_TABEL_NAME_MESSAGE,
                get_class($this)
            ));
        }

        $this->tableName = trim($tableName);

        return $this;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param WilliamEspindola\Article\Entity\EntityInterface
     * @return RepositoryInterface
     */
    public function setEntity(EntityInterface $entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return WilliamEspindola\Article\Entity\EntityInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param WilliamEspindola\Article\Storage\ORM\StorageORMInterface
     * @return RepositoryInterface
     */
    public function setStorage(StorageORMInterface $storage)
    {
        $this->storage = $storage;
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
        $resultSet = $this->getStorage()->findAll($this->getTableName());
        return new \ArrayObject($resultSet);
    }

    /**
     * @param array $criteria
     * @return \ArrayObject
     */
    public function findBy(Array $criteria, Sql $optimization)
    {
        $resultSet = $this->getStorage()
            ->findBy(
                $this->getTableName(),
                $criteria,
                $optimization
            );

        return new \ArrayObject($resultSet);
    }

    /**
     * @param array $criteria
     * @return WilliamEspindola\Article\Entity\EntityInterface
     */
    public function findOne(array $criteria)
    {
        return $this->getStorage()->findOne($this->getTableName(), $criteria);
    }

    /**
     * @param WilliamEspindola\Article\Entity\EntityInterface
     * @return boolean
     */
    public function save(EntityInterface $entity)
    {
        $this->getStorage()->persist($this->getTableName(), $entity);
        $this->getStorage()->flush();

        return true;
    }

    /**
     * @param WilliamEspindola\Article\Entity\EntityInterface
     * @return boolean
     */
    public function remove(EntityInterface $entity)
    {
        $this->getStorage()->remove($this->getTableName(), $entity);
        $this->getStorage()->flush();

        return true;
    }
}
