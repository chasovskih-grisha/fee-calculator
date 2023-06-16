<?php

namespace App\Tests\Unit\Domain\Service\Calculator;

use App\Domain\Model\Transaction;
use App\Domain\Service\Calculator\FeeCalculator;
use App\Domain\Service\Provider\CurrencyRateProviderInterface;
use App\Domain\Service\Provider\Fee\FeePercentProvider;
use App\Domain\Value\Bin;
use App\Domain\Value\Currency;
use PHPUnit\Framework\TestCase;

class FeeCalculatorTest extends TestCase
{
    /**
     * @dataProvider provideCalculate
     */
    public function testCalculate(
        float $amount,
        string $currency,
        float $rate,
        float $percent,
        float $expected
    ): void {
        $calculator = new FeeCalculator(
            $currencyRateProvider = $this->createMock(CurrencyRateProviderInterface::class),
            $feePercentProvider = $this->createMock(FeePercentProvider::class),
        );

        $transaction = new Transaction(
            new Bin('012345'),
            $amount,
            new Currency($currency),
        );

        $currencyRateProvider
            ->expects('EUR' === $currency ? self::never() : self::once())
            ->method('get')
            ->with($transaction->currency)
            ->willReturn($rate);

        $feePercentProvider
            ->expects(self::once())
            ->method('get')
            ->with($transaction)
            ->willReturn($percent);

        self::assertEquals($expected, $calculator->calculate($transaction));
    }

    public function provideCalculate(): array
    {
        return [
            [10, 'USD', 1.2, 0.02, 0.17],
            [10, 'EUR', 1, 0.01, 0.1],
        ];
    }
}
