<?php

namespace App\Domain\Console\Fee;

use App\Application\Command\AbstractConsoleCommand;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\Service\Calculator\FeeCalculator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:fee:calculate',
    description: 'Calculate a fee for all transactions.',
)]
class CalculateCommand extends AbstractConsoleCommand
{
    public function __construct(
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly FeeCalculator                  $feeCalculator
    ) {
        parent::__construct();
    }

    protected function start(): void
    {
        $this->output->write($this->getDescription(), true);

        foreach ($this->transactionRepository->all() as $transaction) {
            $this->output->write($this->feeCalculator->calculate($transaction), true);
        }
    }
}
