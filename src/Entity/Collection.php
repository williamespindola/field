<?php

namespace WilliamEspindola\Field\Entity;

/**
 * Class Collection
 * @package WilliamEspindola\Field\Entity
 */
class Collection implements EntityInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string The name of Collection
     */
    private  $name;

    /**
     * @var string The label of colllection
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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