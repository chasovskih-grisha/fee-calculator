<?php

namespace App\Tests\Unit\Infrastructure\Repository;

use App\Domain\Model\Transaction;
use App\Infrastructure\Repository\MockedTransactionRepository;
use PHPUnit\Framework\TestCase;

class MockedTransactionRepositoryTest extends TestCase
{
    public function testAll(): void
    {
        $repository = new MockedTransactionRepository();

        self::assertCount(5, $transactions = $repository->all());

        foreach ($transactions as $transaction) {
            self::assertInstanceOf(Transaction::class, $transaction);
        }
    }
}
