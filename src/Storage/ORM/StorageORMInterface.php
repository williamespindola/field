<?php

namespace WilliamEspindola\Field\Storage\ORM;

interface StorageORMInterface
{
    /**
     * @param string $tableName
     * @param object $data
     * @return boolean
     */
    public function persist($tableName, $data);
    /**
     * @param $tableName
     * @return array
     */
    public function findAll($tableName);
    /**
     * @param $tableName
     * @param array $criteria for optimizing your clauses
     * @param Query optimization
     * @return void
     */
    public function findBy($tableName, array $criteria, $optimization);
    /**
     * @param $tableName
     * @param array $criteria for optimizing your clauses
     * @return array
     */
    public function findOne($tableName, array $criteria);
    /**
     * @return object Mapper
     */
    public function getMapper();
    /**
     * @param object Mapper
     */
    public function setMapper($mapper);
    /**
     * @return boolean
     */
    public function flush();
} 