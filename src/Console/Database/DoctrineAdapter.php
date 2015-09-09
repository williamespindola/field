<?php
/**
 * Created by PhpStorm.
 * User: williamespindola
 * Date: 9/9/15
 * Time: 4:42 AM
 */

namespace WilliamEspindola\Field\Console\Database;

use WilliamEspindola\Field\Storage\ORM\Doctrine;
use Doctrine\ORM\Tools\Setup;

class DoctrineAdapter
{
    private $conn = [
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'dbname' =>  'field',
        'password' => '123'
    ];

    private $config;

    public function __construct()
    {
        $cofig = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), true);

        return new Doctrine($conn, $cofig);
    }
}