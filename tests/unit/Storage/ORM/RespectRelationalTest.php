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

    public function testToDefineAnEntityNameSpaceForMapperWithValidDataShouldWork()
    {
        $instance = new RespectRelational($this->mapper);
        $namespace = '\\My\Namespace\\Entity\\';
        $instance->setEntityNamespace($namespace);

        $this->assertEquals(
            $this->mapper->entityNamespace,
            $namespace,
            "Namespace isn't equals"
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
} 