<?php

namespace WilliamEspindola\Field\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WilliamEspindola\Field\Console\Command;

class Field extends Application
{
    public function __construct()
    {
        parent::__construct('Field');

        $this->addCommands([
            new Command\Init(),
            new Command\Create()
        ]);
    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        return parent::doRun($input, $output);
    }
}