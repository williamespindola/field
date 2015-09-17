<?php

namespace WilliamEspindola\Field\Storage\ORM;

use Respect\Relational\Mapper;
use Respect\Data\Styles;
use \InvalidArgumentException as Argument;

/**
 * Providers the Respect\Relational\Mapper ORM behavior
 *
 * @package Article
 * @subpackage Storage\ORM
 * @author William Espindola <oi@williamespindola.com.br>
 */
class RespectRelational implements StorageORMInterface
{
    const INVALID_MAPPER_MESSAGE = 'Argument must be Respect\Relational\Mapper';

    /**
     * @var object Respect\Relational\Mapper
     */
    protected $mapper;

    /**
     * @var string table name
     */
    protected $repository;

    public function __construct(Mapper $mapper)
    {
        $this->setMapper($mapper);
    }
    /**
     * @param object Respect\Relational\Mapper
     * @throws \InvalidArgumentException
     */
    public function setMapper($mapper)
    {
        if (!($mapper instanceof Mapper))
            throw new \InvalidArgumentException(RespectRelational::INVALID_MAPPER_MESSAGE);

        $this->mapper = $mapper;
    }

    /**
     * @return object Respect\Relational\Mapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    public function setRepository($repository)
    {
        if (empty($repository))
            throw new Argument('repository param can not be null');

        if (class_exists($repository)) {
            $reflect    = new \ReflectionClass(new $repository);
            $repository = strtolower($reflect->getShortName());
        }

        $this->repository = $repository;

        return $this;
    }

    public function getRepository()
    {
        return $this->getMapper()->$this->repository;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->fetchAll();
    }

    /**
     * @param object $object
     * @return boolean
     */
    public function persist($object)
    {
        if (!is_object($object))
            throw new Argument('The param must be an object');

        return $this->getRepository()->persist($object);
    }

    /**
     * @param string $tableName
     * @param object $data
     */
    public function remove($entity)
    {
        $this->getRepository()->remove($entity);
    }

    /**
     * @param $tableName
     * @param array $criteria for optimizing your clauses
     * * @param Query optimization
     * @return void
     */
    public function findBy(array $criteria, array $optimization)
    {
        $repository = $this->getRepository();
        $repository->setCondition($criteria);

        return $repository->fetchAll($optimization[0]);
    }

    /**
     * @param $tableName
     * @param array $criteria for optimizing your clauses
     * @return object
     */
    public function find($id)
    {
        $repository = $this->getRepository();
        $repository->setCondition(['id' => $id]);

        return $repository->fetch();
    }

    /**
     * @return boolean
     */
    public function flush()
    {
        return $this->getMapper()->flush();
    }
}
