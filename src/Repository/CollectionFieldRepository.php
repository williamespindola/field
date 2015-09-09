<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;

class CollectionFieldRepository
    extends RepositoryAbstract
    implements RepositoryInterface
{
    public function __construct(StorageORMInterface $storage)
    {
        $this->setStorage($storage, 'WilliamEspindola\Field\Entity\CollectionField');
    }
}