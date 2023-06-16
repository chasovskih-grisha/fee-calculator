<?php

namespace App\Domain\Service\Matcher;

use App\Domain\Service\Provider\CountryCodeProviderInterface;
use App\Domain\Value\Bin;
use App\Domain\Value\Region;

class RegionMatcher
{
    private const MAPPING = [
        Region::EU->value => [
            'AT',
            'BE',
            'BG',
            'CY',
            'CZ',
            'DE',
            'DK',
            'EE',
            'ES',
            'FI',
            'FR',
            'GR',
            'HR',
            'HU',
            'IE',
            'IT',
            'LT',
            'LU',
            'LV',
            'MT',
            'NL',
            'PO',
            'PT',
            'RO',
            'SE',
            'SI',
            'SK',
        ],
    ];

    public function __construct(
        readonly private CountryCodeProviderInterface $countryCodeProvider,
    ) {
    }

    public function match(Bin $bin, Region $region): bool
    {
        $countries = self::MAPPING[$region->value] ?? null;

        if (null === $countries) {
            return false;
        }

        $country = $this->countryCodeProvider->get($bin);

        return $country && in_array($country->getValue(), $countries, true);
    }
}
