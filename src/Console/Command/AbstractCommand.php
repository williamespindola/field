<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WilliamEspindola\Field\Console\Command\Database\DoctrineStorage;
use WilliamEspindola\Field\Console\Command\Database\RelationalStorage;

abstract class AbstractCommand extends Command
{
    protected $config;

    /**
     * Bootstrap Field Command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function bootstrap(InputInterface $input, OutputInterface $output)
    {
        if (!$this->getConfig())
            $this->locateConfigFile($input);
    }

    protected function configure()
    {
        $this->addOption(
            '--configuration',
            '-c',
            InputOption::VALUE_REQUIRED, 'The configuration file to load'
        );
    }

    public function locateConfigFile(InputInterface $input)
    {
        $configFile = $input->getOption('configuration');

        if (null === $configFile || false === $configFile) {
            $this->instanceConfig(getcwd() . DIRECTORY_SEPARATOR . 'field.config.php');
            return $this->config;
        }

        $this->instanceConfig($configFile);
        return $configFile;
    }

    protected function instanceConfig($configFilePath)
    {
        ob_start();

        $configArray = include($configFilePath);

        ob_end_clean();
        if (!is_array($configArray)) {
            throw new \RuntimeException(sprintf(
                'PHP file \'%s\' must return an array',
                $configFilePath
            ));
        }

        $this->config = $configArray;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getStorage()
    {
        if (class_exists('Doctrine\ORM\Tools\Setup')) {
            return new DoctrineStorage($this->getConfig());
        } else {
            return new RelationalStorage($this->getConfig());
        }
    }
} 