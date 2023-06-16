<?php

namespace App\Infrastructure\Service\Provider\Mocks;

use App\Domain\Service\Provider\CountryCodeProviderInterface;
use App\Domain\Value\Bin;
use App\Domain\Value\Country;

class RandomCountryCodeProvider implements CountryCodeProviderInterface
{
    private const COUNTRIES = [
        null,
        'UA',
        'NL',
        'FR',
        'DE',
        'US',
    ];

    public function get(Bin $bin): ?Country
    {
        $code = self::COUNTRIES[array_rand(self::COUNTRIES)];

        return $code ? new Country($code) : null;
    }
}
