<?php

namespace WilliamEspindola\Field\Entity;


class CollectionField implements EntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var object Field
     */
    private $field;

    /**
     * @var object Collection
     */
    private $collection;

    /**
     * @param object EntityInterface
     * @return void
     */
    public function setCollection(EntityInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return object
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param object EntityInterface
     */
    public function setField(EntityInterface $field)
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
}