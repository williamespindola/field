<?php

include 'vendor/autoload.php';

use WilliamEspindola\Field\Repository\CollectionRepository;
use WilliamEspindola\Field\Repository\CollectionFieldRepository;
use WilliamEspindola\Field\Storage\ORM\Doctrine;
use WilliamEspindola\Field\Storage\ORM\RespectRelational;
use Doctrine\ORM\Tools\Setup;
use Respect\Relational\Mapper;


$cofig = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), true);
$conn = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'dbname' =>  'field',
    'password' => '123'
];

$mapper = new Mapper(new PDO('mysql:host=127.0.0.1;port=3306;dbname=field','root','123'));

$doctrineStorage = new Doctrine($conn, $cofig);
$respectStorage = new RespectRelational($mapper);

$drepository = new CollectionFieldRepository($doctrineStorage);

$rrepository = new CollectionFieldRepository($respectStorage);

echo "doctrine\n";
echo '<pre>'; var_dump($drepository->findAll()[0]->getCollection()->getLabel()); echo '</pre>';
echo "respect\n";
echo '<pre>'; var_dump($rrepository->findAll()); echo '</pre>';