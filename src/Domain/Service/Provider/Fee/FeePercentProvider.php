<?php

namespace App\Domain\Service\Provider\Fee;

use App\Domain\Model\Transaction;
use App\Domain\Service\Matcher\RegionMatcher;
use App\Domain\Value\Region;

class FeePercentProvider
{
    private const DEFAULT_FEE = 0.02;
    private const FEES = [
        Region::EU->value => 0.01
    ];

    public function __construct(
        private RegionMatcher $regionMatcher,
    ) { }

    public function get(Transaction $transaction): float
    {
        foreach (self::FEES as $region => $fee) {
            if ($this->regionMatcher->match($transaction->bin, Region::from($region))) {
                return $fee;
            }
        }

        return self::DEFAULT_FEE;
    }
}
