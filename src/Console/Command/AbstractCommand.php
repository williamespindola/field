<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Respect\Relational\Mapper;

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
            $this->loadConfig($input, $output);
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

    /**
     * @return Mapper
     * TODO ORM can be suitable
     */
    public function getMapper()
    {
        $dsn    = "{$this->config['driver']}:host={$this->config['host']};dbname={$this->config['dbname']}";
        $mapper = new Mapper(new \PDO($dsn, $this->config['user'], $this->config['password']));
        $mapper->entityNamespace = '\\WilliamEspindola\\Field\\Entity\\';

        return $mapper;
    }

    protected function loadConfig(InputInterface $input, OutputInterface $output)
    {
        $configFilePath = $this->locateConfigFile($input);
        $output->writeln('<info>using config file</info> .' . str_replace(getcwd(), '', realpath($configFilePath)));
    }

    public function getConfig()
    {
        return $this->config;
    }
} 