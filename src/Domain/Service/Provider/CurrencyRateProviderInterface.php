<?php

namespace App\Domain\Service\Provider;

use App\Domain\Exception\Service\Provider\CurrencyRateProviderException;
use App\Domain\Value\Currency;

interface CurrencyRateProviderInterface
{
    /**
     * @throws CurrencyRateProviderException
     */
    public function get(Currency $currency): float;
}
