<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use WilliamEspindola\Field\Entity\Field;
use WilliamEspindola\Field\Entity\Collection;
use WilliamEspindola\Field\Entity\CollectionField;
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
     *
     * TODO Remove the if/else
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);

        $mapper     = $this->getMapper();
        $relational = new RespectRelational($mapper);
        $fieldRepository = new FieldRepository($relational);
        $collectionRepository = new CollectionRepository($relational);
        $collectionFieldRepository = new CollectionFieldRepository($relational);

        $entity      = $input->getArgument('Field|Collection');

        if ($entity === 'Field') {
            $entity      = new Field();
            $entity->setType($input->getArgument('type'));
            $entity->setName($input->getArgument('name'));
            $entity->setLabel($input->getArgument('label'));
            $fieldRepository->save($entity);

            if ($input->getArgument('collection') != null) {

                $collection = $collectionRepository->findOne(['name' => $input->getArgument('collection')]);

                if (!$collection) {
                    $output->writeln('<error>The Collection ' . $input->getArgument('collection') . ' not found.</error>');
                    return;
                }

                $collectionField = new CollectionField();
                $collectionField->setFieldId($entity);
                $collectionField->setCollectionId($collection);
                $collectionFieldRepository->save($collectionField);
            }
        } else {
            $entity      = new Collection();
            $entity->setName($input->getArgument('name'));
            $entity->setLabel($input->getArgument('label'));
            $collectionRepository->save($entity);
        }
    }
}
