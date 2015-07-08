<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use WilliamEspindola\Field\Entity\Field;
use WilliamEspindola\Field\Repository\FieldRepository;
use WilliamEspindola\Field\Storage\ORM\RespectRelational;

class Create extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('create')
            ->setDescription('Create a Field')
            ->addArgument('name', InputArgument::REQUIRED, 'The Name of field')
            ->addArgument('type', InputArgument::REQUIRED, 'The Type of field')
            ->addArgument('label', InputArgument::REQUIRED, 'The Label for the field')
            ->setHelp(sprintf(
                '%sCreates a new field%s',
                PHP_EOL,
                PHP_EOL
            ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);

        $mapper     = $this->getMapper();
        $relational = new RespectRelational($mapper);
        $repository = new FieldRepository($relational);
        $field      = new Field();

        $field->setName($input->getArgument('name'));
        $field->setType($input->getArgument('type'));
        $field->setLabel($input->getArgument('label'));

        $repository->save($field);
    }
}