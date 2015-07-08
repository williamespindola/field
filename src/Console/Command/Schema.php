<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class Schema extends AbstractCommand
{
    const FIELD_MYSQL_SCHEMA = '/../../../data/mysql-schema.sql';

    protected function configure()
    {
        parent::configure();

        $this->setName('schema')
            ->setDescription('Install schema on database')
            ->addArgument('show-only', InputArgument::OPTIONAL, 'Show sql instead install')
            ->setHelp(sprintf(
                '%sInstall schema on database%s',
                PHP_EOL,
                PHP_EOL
            ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);
        $show = $input->getArgument('show-only');

        $schema = file_get_contents(__DIR__ . self::FIELD_MYSQL_SCHEMA);

        if ($show !== null) {
            $output->writeln($schema);
            return;
        }

        $db = $this->getDb();

        $db->query("$schema")->exec();


        $output->writeln('<info>Schema has been installed</info>');
    }
} 