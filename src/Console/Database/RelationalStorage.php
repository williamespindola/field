<?php

namespace WilliamEspindola\Field\Console\Database;

use WilliamEspindola\Field\Storage\ORM\RespectRelational;
use Respect\Relational\Mapper;

class RelationalStorage
{
    public function __construct()
    {
        $mapper = new Mapper(new \PDO($dsn, $this->config['user'], $this->config['password']));

        return new RespectRelational($mapper);
    }
} 