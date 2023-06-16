<?php

namespace App\Infrastructure\Service\Provider\Mocks;

use App\Domain\Service\Provider\CurrencyRateProviderInterface;
use App\Domain\Value\Currency;

class RandomCurrencyRateProvider implements CurrencyRateProviderInterface
{
    public function get(Currency $currency): float
    {
        return $currency->eq(new Currency('EUR')) ? 1 : random_int(1, 10000) / 100;
    }
}
