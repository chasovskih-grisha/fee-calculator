<?php

namespace App\Domain\Console\Fee;

use Symfony\Component\Console\Attribute\AsCommand;
use App\Application\Command\AbstractConsoleCommand;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\Service\Calculator\FeeCalculator;

#[AsCommand(
    name: 'app:fee:calculate',
    description: 'Calculate a fee for all transactions.',
)]
class CalculateCommand extends AbstractConsoleCommand
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private FeeCalculator $feeCalculator
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
