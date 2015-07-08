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
    private $field_id;

    /**
     * @var object Collection
     */
    private $collection_id;

    /**
     * @param object WilliamEspindola\Field\Entity\EntityInterface
     * @return void
     */
    public function setCollectionId(EntityInterface $collection_id)
    {
        $this->collection_id = $collection_id;
    }

    /**
     * @return object
     */
    public function getCollectionId()
    {
        return $this->collection_id;
    }

    /**
     * @param object WilliamEspindola\Field\Entity\EntityInterface
     */
    public function setFieldId(EntityInterface $field_id)
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
}