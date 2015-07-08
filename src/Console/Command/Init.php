<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class Init extends Command
{
    protected function configure()
    {
        $this->setName('init')
            ->setDescription('Initialize the application for Field')
            ->addArgument('path', InputArgument::OPTIONAL, 'Which path should we initialize for Field?')
            ->setHelp(sprintf(
                '%sInitializes the application for Field%s',
                PHP_EOL,
                PHP_EOL
            ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        if (null === $path)
            $path = getcwd();

        $path = realpath($path);

        if (!is_writeable($path)) {
            throw new \InvalidArgumentException(sprintf(
                'The directory "%s" is not writeable',
                $path
            ));
        }

        $fileName = 'field.config.php';
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName;

        if (file_exists($filePath)) {
            throw new \InvalidArgumentException(sprintf(
                'The file "%s" already exists',
                $filePath
            ));
        }

        $contents = <<< EOT
<?php

return [
    'driver' => 'mysql',
    'host'   => 'localhost',
    'dbname'   => 'my_database',
    'user'   => 'my_user',
    'password'   => 'my_pass'
];
EOT;

        if (false === file_put_contents($filePath, $contents)) {
            throw new \RuntimeException(sprintf(
                'The file "%s" could not be written to',
                $path
            ));
        }

        $output->writeln('<info>created</info> .' . str_replace(getcwd(), '', $filePath));
    }
} 