<?php

namespace App\Domain\Console\Fee;

use App\Application\Command\AbstractConsoleCommand;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\Service\Calculator\FeeCalculator;

class CalculateCommand extends AbstractConsoleCommand
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private FeeCalculator $feeCalculator
    ) {
        parent::__construct('app:fee:calculate');
    }

    protected function start(): void
    {
        foreach ($this->transactionRepository->all() as $transaction) {
            $this->output->write($this->feeCalculator->calculate($transaction), true);
        }
    }
}
