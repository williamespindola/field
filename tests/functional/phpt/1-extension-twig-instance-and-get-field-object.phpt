--TEST--
Teste instance the FieldTEigExtension and get field Object
--FILE--
<?php
require 'vendor/autoload.php';

use WilliamEspindola\Field\Extension\FieldTwigExtension;
use WilliamEspindola\Field\Repository\FieldRepository;
use WilliamEspindola\Field\Repository\OptionRepository;
use WilliamEspindola\Field\Storage\ORM\RespectRelational;
use Doctrine\ORM\Tools\Setup;
use WilliamEspindola\Field\Storage\ORM\Doctrine;

$conn               = ['driver' => 'pdo_sqlite', 'memory' => true];
$configXml          = __DIR__ . "../../../config/xml";

$setUp              = Setup::createXMLMetadataConfiguration([$configXml], true);
$storage            = new Doctrine($conn, $setUp);

$fieldRepository    = new FieldRepository($storage);
$optionRepository   = new OptionRepository($storage);

$extension          = FieldTwigExtension($fieldRepository, $optionRepository);

echo gettype($extension->getField('field-name'));
?>
--EXPECT--
object