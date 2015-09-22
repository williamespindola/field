<?php

namespace WilliamEspindola\Field\Repository;

use WilliamEspindola\Field\Storage\ORM\StorageORMInterface;

class CollectionFieldRepository
    extends RepositoryAbstract
    implements RepositoryInterface
{
    /**
     * @var object StorageORMInterface
     */
    protected $storage;

    public function __construct(StorageORMInterface $storage)
    {
        $this->setStorage($storage, 'WilliamEspindola\Field\Entity\CollectionField');
    }

    /**
     * @param StorageORMInterface $storage
     * @param string $repository
     * @return RepositoryAbstract
     */
    public function setStorage(StorageORMInterface $storage, $repository)
    {
        $storage->setRepository($repository);

        $this->storage = $storage->getStorage();

        return $this;
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }
}