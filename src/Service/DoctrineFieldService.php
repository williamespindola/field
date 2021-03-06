<?php

namespace WilliamEspindola\Field\Service;

use WilliamEspindola\Field\Repository\RepositoryInterface;

/**
 * Class DoctrineFieldService
 * @package WilliamEspindola\Field\Service
 */
class DoctrineFieldService
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
     * @return Object WilliamEspindola\Field\Entity\Field
     */
    public function findOneByName($name)
    {
        $field = $this->repository->findBy(
            ['name' => $name],
            [['name' => 'ASC'], null, null]
        );

        return $field ? $field[0] : false;
    }

    /**
     * @param String $name
     * @return String Value of field
     */
    public function findOneByNameAndGetValue($name)
    {
        $fields = $this->repository->findBy(
            ['name' => $name],
            [['name' => 'ASC'], null, null]
        );

        if (!$fields)
            return;

        return $fields[0]->getValue();
    }
} 