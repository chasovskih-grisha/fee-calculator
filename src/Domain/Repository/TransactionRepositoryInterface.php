<?php

namespace App\Domain\Repository;

use App\Domain\Model\Transaction;

interface TransactionRepositoryInterface
{
    /**
     * @return Transaction[]
     */
    public function all(): array;
}