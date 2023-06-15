<?php

namespace App\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractConsoleCommand extends Command
{
    protected InputInterface $input;
    protected OutputInterface $output;

    protected int $result = self::SUCCESS;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        $this->start();

        return $this->result;
    }

    abstract protected function start(): void;
}
