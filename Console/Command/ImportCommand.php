<?php

namespace Goalandfrance\AlpiaImport\Console\Command;

use Goalandfrance\AlpiaImport\Helper\Api\Api;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    /**
     * @var Api
     */
    private $api;

    public function __construct(
        Api $api,
        $name = null)
    {
        parent::__construct($name);
        $this->api = $api;
    }

    protected function configure()
    {
        $this->setName('goalandfrance-alpiaimport:import')
            ->setDescription('Import awaiting products');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->api->export()) {
            $output->writeln("Your import request is queued in Alpia");
        } else {
            $output->writeln("ERROR: your request was canceled");
        }
    }
}
