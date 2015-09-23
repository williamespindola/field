<?php

namespace WilliamEspindola\Field\Entity;

/**
 * Class Options
 * @package WilliamEspindola\Field\Entity
 */
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
     *  @var WilliamEspindola\Field\Entity\EntityInterface
     */
    private $language;

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

    /**
     * @param \WilliamEspindola\Field\Entity\EntityInterface $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return \WilliamEspindola\Field\Entity\EntityInterface
     */
    public function getLanguage()
    {
        return $this->language;
    }
}