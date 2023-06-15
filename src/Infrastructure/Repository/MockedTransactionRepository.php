<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Transaction;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\Value\Bin;
use App\Domain\Value\Currency;

class MockedTransactionRepository implements TransactionRepositoryInterface
{
    private const FILEPATH = 'var/resources/input.txt';

    public function all(): array
    {
        $transactions = [];
        foreach (explode("\n", file_get_contents(self::FILEPATH)) as $row) {
            $data = json_decode($row, true);

            $transactions[] = new Transaction(
                new Bin($data['bin']),
                $data['amount'],
                new Currency($data['currency']),
            );
        }

        return $transactions;
    }
}
