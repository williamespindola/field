<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Entity\Collection;
use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;

class CollectionRepository
    extends RepositoryAbstract
    implements RepositoryInterface
{
    public function __construct(StorageORMInterface $storage)
    {
        parent::__construct('collection', new Collection(), $storage);
    }
}