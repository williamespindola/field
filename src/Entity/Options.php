<?php

namespace WilliamEspindola\Field\Entity;

class Options implements EntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var text
     */
    private $value;

    /**
     * $var object WilliamEspindola\Field\Entity\Field
     */
    private $field;

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param text $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return text
     */
    public function getValue()
    {
        return $this->value;
    }
}