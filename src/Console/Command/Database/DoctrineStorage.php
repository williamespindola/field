<?php

namespace WilliamEspindola\Field\Console\Command\Database;

use WilliamEspindola\Field\Storage\ORM\Doctrine;
use Doctrine\ORM\Tools\Setup;

class DoctrineStorage
{
    protected $mapper;

    const XML_CONFIG_ORM = '/../../../../config/xml/';

    public function __construct($config)
    {
        $setUp = Setup::createXMLMetadataConfiguration([__DIR__ . self::XML_CONFIG_ORM], true);

        $this->mapper =  new Doctrine($config, $setUp);
    }

    public function getMapperInstance()
    {
        return $this->mapper;
    }

    public function getExecuteQuery($query)
    {
        $stmt = $this->mapper->getMapper()->getConnection()->prepare($query);

        return $stmt->execute();
    }
}