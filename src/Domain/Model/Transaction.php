<?php

namespace App\Domain\Model;

use App\Domain\Value\Bin;
use App\Domain\Value\Currency;

class Transaction
{
    public function __construct(
        public readonly Bin $bin,
        public readonly float $amount,
        public readonly Currency $currency,
    ) {
    }
}
