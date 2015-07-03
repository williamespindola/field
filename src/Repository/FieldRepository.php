<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Entity\Field;
use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;

class FieldRepository
    extends RepositoryAbstract
    implements RepositoryInterface
{
    public function __construct(StorageORMInterface $storage)
    {
        parent::__construct('field', new Field(), $storage);
    }
}