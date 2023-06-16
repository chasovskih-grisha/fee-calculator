<?php

namespace App\Tests\Unit\Domain\Service\Matcher;

use App\Domain\Service\Matcher\RegionMatcher;
use App\Domain\Service\Provider\CountryCodeProviderInterface;
use App\Domain\Value\Bin;
use App\Domain\Value\Country;
use App\Domain\Value\Region;
use PHPUnit\Framework\TestCase;

class RegionMatcherTest extends TestCase
{
    /**
     * @dataProvider provideMatch
     */
    public function testMatch(Region $region, Country $country, bool $match): void
    {
        $matcher = new RegionMatcher(
            $countryCodeProvider = $this->createMock(CountryCodeProviderInterface::class),
        );

        $countryCodeProvider
            ->expects(self::once())
            ->method('get')
            ->with($bin = new Bin('12345'))
            ->willReturn($country);

        self::assertEquals($match, $matcher->match($bin, $region));
    }

    public function provideMatch(): array
    {
        return [
            [Region::EU, new Country('DE'), true],
            [Region::EU, new Country('CH'), false],
        ];
    }
}
