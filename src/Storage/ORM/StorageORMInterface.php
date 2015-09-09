<?php

namespace WilliamEspindola\Field\Storage\ORM;

use WilliamEspindola\Field\Entity\EntityInterface;

/**
 * Interface StorageORMInterface
 *
 * Provides an interface for ORM mapper implementation
 *
 * @package WilliamEspindola\Field\Storage\ORM
 * @author William Espindola <oi@williamespindola.com.br>
 */
interface StorageORMInterface
{
    /**
     * Define a mapper to use on storage
     *
     * @param object $mapper
     */
    public function setMapper($mapper);

    /**
     * Get storage mapper
     *
     * @return object $mapper
     */
    public function getMapper();

    /**
     * Persist new entity
     *
     * @param $entity
     * @return boolean
     */
    public function persist($entity);

    /**
     * Return all data from repository
     *
     * @return array
     */
    public function findAll();

    /**
     * Find some data by criteria and optimization like order, limit or offset
     *
     * @param array $criteria for optimizing your clauses
     * @param array optimization
     * @return void
     */
    public function findBy(array $criteria, array $optimization);

    /**
     * Return matched entity
     *
     * @param inteer $id
     * @return object
     */
    public function find($id);

    /**
     * Flush!
     *
     * @return boolean
     */
    public function flush();

    /**
     * @return mixed
     */
    public function getRepository();

    /**
     * @param $repository
     * @return mixed
     */
    public function setRepository($repository);
} 