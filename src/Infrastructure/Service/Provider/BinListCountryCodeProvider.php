<?php

namespace App\Infrastructure\Service\Provider;

use App\Domain\Exception\Service\Provider\CountryCodeProviderException;
use App\Domain\Service\Provider\CountryCodeProviderInterface;
use App\Domain\Value\Bin;
use App\Domain\Value\Country;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BinListCountryCodeProvider implements CountryCodeProviderInterface
{
    public function __construct(
        private HttpClientInterface $binlistClient,
    ) { }

    public function get(Bin $bin): ?Country
    {
        $response = $this->binlistClient->request('GET', $bin->getValue());

        if (Response::HTTP_OK !== ($code = $response->getStatusCode())) {
            throw new CountryCodeProviderException(sprintf('Unable to receive response from Binlist. Response code %s', $code));
        }

        $content = json_decode($response->getContent(), true);
        $alpha2 = $content['country']['alpha2'] ?? null;

        return $alpha2 ? new Country($alpha2) : null;
    }
}
