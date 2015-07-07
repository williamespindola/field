<?php

use WilliamEspindola\Field\Repository\RepositoryAbstract;

class RepositoryAbstractTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->entity = $this->getMock('\WilliamEspindola\Field\Entity\EntityInterface');
        $this->storage = $this->getMock('\WilliamEspindola\Field\Storage\ORM\StorageORMInterface');

        $this->storage->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue([]));

        $this->repository = new MockRepository('tableName', $this->entity, $this->storage);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid table name MockRepository.
     */
    public function testSetTableNameWidhInvalidDataShuldThrownAndException()
    {
        $this->repository->setTableName(1);
    }

    public function testeSetTableNameWithValidDataShouldWork()
    {
        $this->repository->setTableName('ola');
        $this->assertEquals('ola', PHPUnit_Framework_Assert::readAttribute($this->repository, 'tableName'));
    }

    public function testeGetTableNameWithValidDataShouldWork()
    {
        $this->repository->setTableName('ola');
        $this->assertEquals('ola', $this->repository->getTableName());
    }

    public function testSetAndGetEntityWithValidDataShouldWork()
    {
        $this->repository->setEntity($this->entity);
        $this->assertInstanceOf(
            '\WilliamEspindola\Field\Entity\EntityInterface',
            $this->repository->getEntity()
        );
    }

    public function testSetAndGetStorageWithValidDataShouldWork()
    {
        $this->repository->setStorage($this->storage);
        $this->assertInstanceOf(
            '\WilliamEspindola\Field\Storage\ORM\StorageORMInterface',
            $this->repository->getStorage()
        );
    }

    public function testFindAllShouldReturnAnArrayObject()
    {
        $this->assertInstanceOf('ArrayObject', $this->repository->findAll());
    }
}

class MockRepository extends RepositoryAbstract {}