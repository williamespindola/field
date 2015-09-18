<?php

use WilliamEspindola\Field\Repository\RepositoryAbstract;

class RepositoryAbstractTest extends PHPUnit_Framework_TestCase
{
    public function testSetAndGetStorageWithValidDataShouldWork()
    {
        $storageAbstract = $this->getMock('sdtClass', ['findAll']);

        $storage = $this->getMock('\WilliamEspindola\Field\Storage\ORM\StorageORMInterface');

        $storage->expects($this->any())
            ->method('__get')
            ->with($this->equalTo('storage'))
            ->will($this->returnValue($storageAbstract));

        $storage->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($storageAbstract));

        $repository = new MockRepository($storage, 'sdtClass');

        $repository->setStorage($storage, 'sdtClass');

        $this->assertInstanceOf(
            'sdtClass',
            $repository->getStorage()
        );
    }

    public function testFindAllShouldReturnAnArrayObject()
    {
        $storageAbstract = $this->getMock('sdtClass', ['findAll']);

        $storageAbstract->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue((object)([])));

        $storage = $this->getMock('\WilliamEspindola\Field\Storage\ORM\StorageORMInterface');

        $storage->expects($this->any())
            ->method('__get')
            ->with($this->equalTo('storage'))
            ->will($this->returnValue($storageAbstract));

        $storage->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($storageAbstract));

        $repository = new MockRepository($storage, 'sdtClass');

        $repository->setStorage($storage, 'sdtClass');

        $this->assertInstanceOf('stdClass', $repository->findAll());
    }
}

class MockRepository extends RepositoryAbstract {}

