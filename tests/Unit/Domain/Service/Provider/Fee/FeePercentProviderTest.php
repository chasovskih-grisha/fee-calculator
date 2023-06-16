<?php

namespace App\Tests\Unit\Domain\Service\Provider\Fee;

use App\Domain\Model\Transaction;
use App\Domain\Service\Matcher\RegionMatcher;
use App\Domain\Service\Provider\Fee\FeePercentProvider;
use App\Domain\Value\Bin;
use App\Domain\Value\Currency;
use PHPUnit\Framework\TestCase;

class FeePercentProviderTest extends TestCase
{
    /**
     * @dataProvider provideGet
     */
    public function testGet(bool $match, float $percent): void
    {
        $provider = new FeePercentProvider(
             $regionMatcher = $this->createMock(RegionMatcher::class),
        );

        $transaction = new Transaction(
            new Bin('012345'),
            12.34,
            new Currency('EUR'),
        );

        $regionMatcher
            ->expects(self::once())
            ->method('match')
            ->with($transaction->bin)
            ->willReturn($match);

        self::assertEquals($percent, $provider->get($transaction));
    }

    public function provideGet(): array
    {
        return [
            [true, 0.01],
            [false, 0.02],
        ];
    }
}
