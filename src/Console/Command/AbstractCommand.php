<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Respect\Relational\Mapper;
use Respect\Relational\Db;

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

    /**
     * @return Db
     */
    public function getDb()
    {
        $dsn    = "{$this->config['driver']}:host={$this->config['host']};dbname={$this->config['dbname']}";
        $db = new Db(new \PDO($dsn, $this->config['user'], $this->config['password']));

        return $db;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getStorage()
    {
        $dsn    = "{$this->config['driver']}:host={$this->config['host']};dbname={$this->config['dbname']}";

        if (class_exists('Doctrine\ORM\Tools\Setup')) {
            return new \WilliamEspindola\Field\Console\Database\DoctrineStorage();
        } else {
            return new \WilliamEspindola\Field\Console\Database\RelationalStorage();
        }
    }
} 