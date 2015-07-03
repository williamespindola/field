<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Entity\Option;
use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;

class OptionRepository
    extends RepositoryAbstract
    implements RepositoryInterface
{
    public function __construct(StorageORMInterface $storage)
    {
        parent::__construct('option', new Option(), $storage);
    }
}