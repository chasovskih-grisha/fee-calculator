<?php

namespace App\Infrastructure\Service\Provider;

use App\Domain\Exception\Service\Provider\CurrencyRateProviderException;
use App\Domain\Service\Provider\CurrencyRateProviderInterface;
use App\Domain\Value\Currency;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRatesApiProvider implements CurrencyRateProviderInterface
{
    public function __construct(
        private readonly HttpClientInterface $exchangeratesapiClient,
        private readonly string $accessKey,
    ) {
    }

    public function get(Currency $currency): float
    {
        $response = $this->exchangeratesapiClient->request('GET', '/latest', [
            'query' => [
                'access_key' => $this->accessKey,
            ],
        ]);

        if (Response::HTTP_OK !== ($code = $response->getStatusCode())) {
            throw new CurrencyRateProviderException(sprintf('ExchangeRates API Response code: %s', $code));
        }

        $content = json_decode($response->getContent(), true);
        $rate = $content['rates'][$currency->getValue()] ?? null;

        if (null === $rate) {
            throw new CurrencyRateProviderException(sprintf('Rate not found for currency %s', $currency));
        }

        return $rate;
    }
}
