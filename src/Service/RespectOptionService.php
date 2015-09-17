<?php

namespace WilliamEspindola\Field\Service;

use Respect\Relational\Sql;
use WilliamEspindola\Field\Repository\RepositoryInterface;

/**
 * Class RespectOptionService
 * @package WilliamEspindola\Field\Service
 */
class RespectOptionService
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __costruct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Object $field
     * @param String $order
     * @return ArrayObject Options of field
     */
    public function getOptionsOfField($field, $order)
    {
        return $this->repository->findBy(
            ['field_id' => $field->id],
            Sql::orderBy($order)
        );
    }
}