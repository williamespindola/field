<?php

use WilliamEspindola\Field\Repository\OptionRepository;

class OptionRepositoryTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->storage = $this->getMock('\WilliamEspindola\Field\Storage\ORM\StorageORMInterface');

        $this->storage->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue([]));

        $this->repository = new OptionRepository($this->storage);
    }

    public function testFindAllShouldReturnAnArrayObject()
    {
        $this->assertInstanceOf('ArrayObject', $this->repository->findAll());
    }
}