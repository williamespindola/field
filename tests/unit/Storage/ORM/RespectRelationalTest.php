<?php

use WilliamEspindola\Field\Storage\ORM\RespectRelational;

use Respect\Relational\Mapper;
use Respect\Data\Collections\Collection;

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

        $instance->setRepository('MyNamespace\MyClass');

        $this->assertInstanceOf(
            'Respect\Data\Collections\Collection',
            PHPUnit_Framework_Assert::readAttribute($instance, 'repository'),
            'The attribute repository is not instance of the string class name: Respect\Data\Collections\Collection'
        );
    }

    public function testGetRepositoryShouldReturnMockedInstance()
    {
        $conn = $this->getMock(
            'PDO',
            array('lastInsertId'),
            array('sqlite::memory:')
        );
        $conn->exec('CREATE TABLE mytable(id INTEGER PRIMARY KEY)');
        $conn->expects($this->any())
            ->method('lastInsertId')
            ->will($this->throwException(new \PDOException));


        $mapper = new Mapper($conn);

        $instance = new RespectRelational($mapper);
        $instance->setRepository('mytable');

        $this->assertInstanceOf(
            'Respect\Data\Collections\Collection',
            $instance->getRepository(),
            'The attribute repository is not instance of the string class name: Respect\Data\Collections\Collection'
        );
    }
}
