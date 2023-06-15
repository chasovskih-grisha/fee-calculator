<?php

namespace App\Domain\Value;

use App\Application\Value\AbstractStringValue;
use App\Domain\Exception\Value\InvalidCountryException;

class Country extends AbstractStringValue
{
    private const LENGTH = 2;

    protected function assert(): void
    {
        parent::assert();

        if (self::LENGTH !== strlen($this->value)) {
            throw new InvalidCountryException(sprintf('Invalid country code %s', $this->value));
        }
    }
}
