<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use WilliamEspindola\Field\Repository\CollectionFieldRepository;
use WilliamEspindola\Field\Repository\CollectionRepository;
use WilliamEspindola\Field\Repository\FieldRepository;
use WilliamEspindola\Field\Storage\ORM\RespectRelational;

class Create extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('create')
            ->setDescription('Create a Field or an Collection')
            ->addArgument('Field|Collection', InputArgument::REQUIRED, 'Field or Collection')
            ->addArgument('name', InputArgument::REQUIRED, 'The name is the identify of our Field or your Collection')
            ->addArgument('label', InputArgument::REQUIRED, 'The Label for the presentation of your Field or Collection')
            ->addArgument('type', InputArgument::OPTIONAL, 'The type of field (only field has types)')
            ->addArgument('collection', InputArgument::OPTIONAL, 'The collection name of field new field')
            ->setHelp(sprintf(
                "%sCreates a new Field or a new Collection examples: \n create Field keywords text Keywords header \n create Collection header Header%s",
                PHP_EOL,
                PHP_EOL
            ));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);

        $storage = $this->getStorage();

        if ($input->getArgument('Field|Collection') === 'Collection') {
            $this->createCollection($input, $storage);
            $output->writeln('<info>Collection ' . $input->getArgument('name') . ' was been created.</info>');
            return;
        }

        if ($input->getArgument('collection') != null) {
            $collection = $this->findACollection($input, $storage);
            if (!$collection) {
                $output->writeln('<error>The Collection ' . $input->getArgument('collection') . ' not found.</error>');
                return;
            }

            $field = $this->createField($input, $storage);
            $this->createTheFieldCollectionRelationship($field, $collection[0], $storage);
            $output->writeln(
                '<info>Field '
                . $input->getArgument('name')
                . ' was been created with to collection '
                . $input->getArgument('collection')
                . '</info>');
            return;
        }

        $this->createField($input, $storage);
        $output->writeln('<info>Field ' . $input->getArgument('name') . ' was been created.</info>');
    }

    private function createCollection(InputInterface $input, $storage)
    {
        $collectionRepository   = new CollectionRepository($storage);

        $collection = (object)([
            'name' => $input->getArgument('name'),
            'label' => $input->getArgument('label')
        ]);

        $collectionRepository->save($collection);

        return $collection;
    }

    private function createField(InputInterface $input, $storage)
    {
        $fieldRepository    = new FieldRepository($storage);

        $field = (object)([
            'type' => $input->getArgument('type'),
            'name' => $input->getArgument('name'),
            'label' => $input->getArgument('label')
        ]);

        $fieldRepository->save($field);

        return $field;
    }

    private function findACollection(InputInterface $input, $storage)
    {
        $collectionRepository = new CollectionRepository($storage);

        return $collectionRepository->findBy(
            ['name' => $input->getArgument('collection')],
            ['order by name']
        );
    }

    private function createTheFieldCollectionRelationship($entity, $collection, $storage)
    {
        $collectionFieldRepository = new CollectionFieldRepository($storage);

        $collectionField = (object)([
            'field_id' => $entity,
            'collection_id' => $collection
        ]);

        $collectionFieldRepository->save($collectionField);

        return $collectionField;
    }
}
