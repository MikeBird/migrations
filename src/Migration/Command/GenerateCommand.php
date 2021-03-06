<?php

namespace Odan\Migration\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{

    /**
     * configure
     */
    protected function configure()
    {
        $this->setName('migration:generate')
                ->setDescription('Generate migration')
                //->addArgument('config', InputArgument::OPTIONAL, 'Configuration file.', 'migrations-config.php')
                // php migrations.php migration:generate --config=myconfig.php
                ->addOption('config', null, InputOption::VALUE_OPTIONAL, 'Configuration file.', 'migrations-config.php')
        ;
    }

    /**
     * Execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $settings = $this->getSettings($input);
        $generator = new \Odan\Migration\Generator\MigrationGenerator($settings, $input, $output);
        $generator->generate();
    }

    /**
     *
     * @return mixed
     * @throws Exception
     */
    protected function getSettings(InputInterface $input)
    {
        $configFile = $input->getOption('config');
        if (!file_exists($configFile)) {
            throw new Exception(sprintf('File not found: %s', $configFile));
        }
        return $this->read($configFile);
    }

    /**
     * Get config
     *
     * @param string $filename
     * @return mixed
     */
    protected function read($filename)
    {
        return require $filename;
    }

}
