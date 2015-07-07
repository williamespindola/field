<?php

use WilliamEspindola\Field\Repository\FieldRepository;

class FieldRepositoryTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->storage = $this->getMock('\WilliamEspindola\Field\Storage\ORM\StorageORMInterface');

        $this->storage->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue([]));

        $this->repository = new FieldRepository($this->storage);
    }

    public function testFindAllShouldReturnAnArrayObject()
    {
        $this->assertInstanceOf('ArrayObject', $this->repository->findAll());
    }
}