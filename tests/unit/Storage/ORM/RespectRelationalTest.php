<?php

use WilliamEspindola\Field\Storage\ORM\RespectRelational;

class RespectRelationalTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->mapper = $this->getMockBuilder('Respect\Relational\Mapper')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->mapper->expects($this->any())
                    ->method(new PHPUnit_Framework_Constraint_IsAnything())
                    ->with($this->returnSelf());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetMapperWithInvalidParameterShouldThrownAndInvalidArgumentException()
    {
        $instance = new RespectRelational($this->mapper);
        $instance->setMapper('bla');
    }

    public function testSetMapperWithValidParameterShouldReturnMapperInGetMapper()
    {
        $instance = new RespectRelational($this->mapper);
        $instance->setMapper($this->mapper);
        $this->assertInstanceOf(
            'Respect\Relational\Mapper',
            PHPUnit_Framework_Assert::readAttribute($instance, 'mapper'),
            'The attribute mapper is not instance of Respect\Relational\Mapper'
        );
    }

    public function testGetMapperShouldReturnMockedInstance()
    {
        $instance = new RespectRelational($this->mapper);
        $this->assertInstanceOf(
            'Respect\Relational\Mapper',
            $instance->getMapper(),
            'The instance returned by getMapper is not instance of Respect\Relational\Mapper'
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetRepositoryWithInvalidValueShouldThrowAndException()
    {
        $instance   = new RespectRelational($this->mapper);

        $instance->setRepository('');
    }

    /**
     * @depends testSetRepositoryWithInvalidValueShouldThrowAndException
     */
    public function testSetRepositoryWithAValidNamespaceShouldWork()
    {
        $instance   = new RespectRelational($this->mapper);
        $stubClass  = $this->getMock('MyNamespace\MyClass');

        $instance->setRepository('MyNamespace\MyClass');

        $this->assertEquals(
            'myclass',
            PHPUnit_Framework_Assert::readAttribute($instance, 'repository'),
            'The attribute repository is not instance of the string class name: myclass'
        );
    }

    /**
     * @depends testSetRepositoryWithAValidNamespaceShouldWork
     */
    public function testSetRepositoryWithValidStringShouldWork()
    {
        $instance   = new RespectRelational($this->mapper);

        $instance->setRepository('mytable');

        $this->assertEquals(
            'mytable',
            PHPUnit_Framework_Assert::readAttribute($instance, 'repository'),
            'The attribute repository is not instance of the string table name: mytable'
        );
    }

    /**
     * @depends testSetRepositoryWithValidStringShouldWork
     */
    public function testGetRepositoryShouldReturnMockedInstance()
    {
        $conn = $this->getMock(
            'PDO',
            ['lastInsertId'],
            ['sqlite::memory:']
        );
        $conn->exec('CREATE TABLE mytable(id INTEGER PRIMARY KEY)');
        $conn->expects($this->any())
            ->method('lastInsertId')
            ->will($this->throwException(new \PDOException));

        $mapper = $this->getMockBuilder('Respect\Relational\Mapper')
                            ->disableOriginalConstructor()
                            ->getMock();

        $collection = $this->getMock(
            'Respect\Data\Collections\Collection',
            ['setMapper'],
            ['mytable']
        );

        $mapper->expects($this->any())
            ->method('__get')
            ->will($this->returnValue($collection));

        $instance = new RespectRelational($mapper);
        $instance->setRepository('mytable');

        $this->assertInstanceOf(
            'Respect\Data\Collections\Collection',
            $instance->getRepository(),
            'The instance returned by getRepository is not instance of Respect\Data\Collections\Collection'
        );
    }
} 