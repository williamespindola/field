<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Respect\Relational\Mapper;

class Create extends Command
{
    protected $mapper;

    protected function configure()
    {
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
        $cwd = getcwd() . DIRECTORY_SEPARATOR . 'field.ini';

        $parse = parse_ini_file($cwd);

        $this->mapper = new Mapper(new \PDO($parse['db_dsn'], $parse['db_user'], $parse['db_pass']));

        $field = (object)([
            'id' => null,
            'name' => $input->getArgument('name'),
            'type' => $input->getArgument('name'),
            'label' => $input->getArgument('name')
        ]);

        $this->mapper->field->persist($field);
        $this->mapper->flush();
    }
} 