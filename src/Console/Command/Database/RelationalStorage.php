<?php

namespace WilliamEspindola\Field\Console\Command\Database;

use WilliamEspindola\Field\Storage\ORM\RespectRelational;
use Respect\Relational\Mapper;
use Respect\Relational\Db;

class RelationalStorage
{
    protected $db;

    protected $mapper;

    public function __construct($config)
    {
        $dsn            = "{$config['driver']}:host={$config['host']};dbname={$config['dbname']}";
        $this->db       = new Db(new \PDO($dsn, $config['user'], $config['password']));
        $this->mapper   = new Mapper($this->db);
    }

    public function getMapperInstance()
    {
        return new RespectRelational($this->mapper);
    }

    public function getExecuteQuery($query)
    {
        $this->db->query("$query")->exec();
    }
} 