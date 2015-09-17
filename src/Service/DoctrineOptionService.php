<?php

namespace WilliamEspindola\Field\Service;

use WilliamEspindola\Field\Repository\RepositoryInterface;

/**
 * Class DoctrineOptionService
 * @package WilliamEspindola\Field\Service
 */
class DoctrineOptionService
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
        return $this->optionRepository->findBy(
            ['field_id' => $field->getId()],
            ['order' => $order]
        );
    }
}