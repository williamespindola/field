<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Entity\CollectionField;
use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;

class CollectionFieldRepository
    extends RepositoryAbstract
    implements RepositoryInterface
{
    public function __construct(StorageORMInterface $storage)
    {
        parent::__construct('collection_field', new CollectionField(), $storage);
    }
}