<?php

namespace WilliamEspindola\Field\Service;

use WilliamEspindola\Field\Repository\RepositoryInterface;

/**
 * Class RespectFieldService
 * @package WilliamEspindola\Field\Service
 */
class RespectFieldService
{
    /**
     * @var \WilliamEspindola\Field\Repository\RepositoryInterface
     */
    protected $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param String $name
     * @return Object Field object
     */
    public function findOneByName($name)
    {
        $field = $this->repository->findBy(['name' => $name], ['order by name asc']);

        return $field ? $field[0] : false;
    }

    /**
     * @param String $name
     * @return String Value of field
     */
    public function findOneByNameAndGetValue($name)
    {
        $fields = $this->repository->findBy(['name' => $name], ['order by name asc']);

        if (!$fields)
            return;

        return $fields[0]->value;
    }
} 