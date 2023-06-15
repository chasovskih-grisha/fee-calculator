<?php

namespace App\Domain\Service\Provider;

use App\Domain\Exception\Service\Provider\CountryCodeProviderException;
use App\Domain\Value\Bin;
use App\Domain\Value\Country;

interface CountryCodeProviderInterface
{
    /**
     * @throws CountryCodeProviderException
     */
    public function get(Bin $bin): ?Country;
}
