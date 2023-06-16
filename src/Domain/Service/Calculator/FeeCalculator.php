<?php

namespace App\Domain\Service\Calculator;

use App\Domain\Model\Transaction;
use App\Domain\Service\Provider\CurrencyRateProviderInterface;
use App\Domain\Service\Provider\Fee\FeePercentProvider;
use App\Domain\Value\Currency;

class FeeCalculator
{
    private const DEFAULT_CURRENCY = 'EUR';

    private const PRECISION = 2;

    public function __construct(
        private readonly CurrencyRateProviderInterface $currencyRateProvider,
        private readonly FeePercentProvider $feePercentProvider
    ) {
    }

    public function calculate(Transaction $transaction): float
    {
        $total = $transaction->currency->eq(new Currency(self::DEFAULT_CURRENCY))
            ? $transaction->amount
            : $transaction->amount / $this->currencyRateProvider->get($transaction->currency);

        return round($total * $this->feePercentProvider->get($transaction), self::PRECISION);
    }
}
