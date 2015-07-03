<?php

namespace WilliamEspindola\Field\Entity;

class Options
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var text
     */
    private $option;

    /**
     * $var object WilliamEspindola\Field\Entity\Field
     */
    private $field_id;

    /**
     * @param mixed $field_id
     */
    public function setFieldId($field_id)
    {
        $this->field_id = $field_id;
    }

    /**
     * @return mixed
     */
    public function getFieldId()
    {
        return $this->field_id;
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
     * @param text $option
     */
    public function setOption($option)
    {
        $this->option = $option;
    }

    /**
     * @return text
     */
    public function getOption()
    {
        return $this->option;
    }
}