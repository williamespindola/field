--TEST--
Teste instance the FieldTEigExtension and get field Object
--FILE--
<?php
require 'vendor/autoload.php';

use WilliamEspindola\Field\Extension\FieldTwigExtension;
use WilliamEspindola\Field\Repository\FieldRepository;
use Doctrine\ORM\Tools\Setup;
use WilliamEspindola\Field\Storage\ORM\Doctrine;

$conn               = ['driver' => 'pdo_mysql', 'user' => 'root', 'password' => '123', 'dbname' => 'field'];
$configXml          = __DIR__ . "/xml/";

$setUp              = Setup::createXMLMetadataConfiguration([$configXml], true);
$storage            = new Doctrine($conn, $setUp);

$stmt = $storage->getMapper()->getConnection()->prepare("
CREATE TABLE IF NOT EXISTS field (
  id INTEGER PRIMARY KEY,
  name TEXT NOT NULL,
  type TEXT NOT NULL,
  value TEXT NULL,
  label TEXT NOT NULL
);
INSERT INTO field (id, name, type, value, label) VALUES (1, 'field-name', 'text', 'field-name', 'field-name');
");
$stmt->execute();
$stmt->closeCursor();

$fieldRepository    = new FieldRepository($storage);

$extension          = new FieldTwigExtension($fieldRepository);

echo $extension->getFieldValue('field-name');

$stmt = $storage->getMapper()->getConnection()->prepare("DROP TABLE field;");
$stmt->execute();
$stmt->closeCursor();
?>
--EXPECT--
field-name