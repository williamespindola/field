<?php

namespace WilliamEspindola\Field\Console\Command\Database;

use WilliamEspindola\Field\Storage\ORM\Doctrine;
use Doctrine\ORM\Tools\Setup;

class DoctrineStorage
{
    protected $mapper;

    public function __construct($config)
    {
        $setUp = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), true);

        $this->mapper =  new Doctrine($config, $setUp);
    }

    public function getMapperInstance()
    {
        return $this->mapper->getMapper();
    }

    public function getExecuteQuery($query)
    {
        $stmt = $this->mapper->getMapper()->getConnection()->prepare($query);

        return $stmt->execute();
    }
}