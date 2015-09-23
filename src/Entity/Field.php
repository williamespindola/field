<?php

namespace WilliamEspindola\Field\Entity;

/**
 * Class Field
 * @package WilliamEspindola\Field\Entity
 */
class Field implements EntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var text
     */
    private $value;

    /**
     * @var string
     */
    private $label;

    /**
     * @var EntityInterface Language
     */
    private $language;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
    public function setLanguage(EntityInterface $language)
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