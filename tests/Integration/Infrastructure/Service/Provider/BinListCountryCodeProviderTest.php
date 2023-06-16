<?php

namespace App\Tests\Integration\Infrastructure\Service\Provider;

use App\Domain\Value\Bin;
use App\Domain\Value\Country;
use App\Infrastructure\Service\Provider\BinListCountryCodeProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BinListCountryCodeProviderTest extends KernelTestCase
{

    /**
     * @dataProvider provideGet
     */
    public function testGet(string $bin, ?string $country): void
    {
        self::bootKernel();

        /* @var BinListCountryCodeProvider $provider */

        $provider = static::getContainer()->get(BinListCountryCodeProvider::class);

        self::assertInstanceOf(BinListCountryCodeProvider::class, $provider);

        self::assertEquals($country ? new Country($country) : null, $provider->get(new Bin($bin)));
    }

    public function provideGet(): array
    {
        return [
            ['45717360', 'DK'],
            ['516793', 'LT'],
            ['45417360', 'JP'],
        ];
    }
}
