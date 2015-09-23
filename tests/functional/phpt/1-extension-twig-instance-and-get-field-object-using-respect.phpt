--TEST--
Teste instance the FieldTEigExtension and get field Object
--FILE--
<?php
require 'vendor/autoload.php';

use WilliamEspindola\Field\Extension\FieldTwigExtension;
use WilliamEspindola\Field\Repository\FieldRepository;
use WilliamEspindola\Field\Storage\ORM\RespectRelational;
use Respect\Relational\Mapper;
use Respect\Relational\Db;

$db                 = new Db(new PDO("mysql:host=localhost;dbname=field", 'root', '123'));
$mapper             = new Mapper($db);
$storage            = new RespectRelational($mapper);

$db->query("
CREATE TABLE IF NOT EXISTS field (
  id INTEGER PRIMARY KEY,
  name TEXT NOT NULL,
  type TEXT NOT NULL,
  value TEXT NULL,
  label TEXT NOT NULL
);
INSERT INTO field (id, name, type, value, label) VALUES (1, 'field-name', 'text', 'field-name', 'field-name');
")->exec();

$fieldRepository    = new FieldRepository($storage);

$extension          = new FieldTwigExtension($fieldRepository);

echo gettype($extension->getField('field-name'));

//$db->query("DROP TABLE field;")->exec();
?>
--EXPECT--
object