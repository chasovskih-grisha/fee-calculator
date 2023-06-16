<?php

namespace App\Tests\Functional\Domain\Console\Fee;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CalculateCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $application = new Application(self::bootKernel());

        $commandTester = new CommandTester($application->find('app:fee:calculate'));
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();

        $this->assertStringContainsString(
            'Calculate a fee for all transactions',
            $output = $commandTester->getDisplay(),
        );

        $this->assertStringContainsString(
            '1',
            $output,
            'We expect at least one fee that equals 1 EUR from fake transaction with 100 EUR amount',
        );
    }
}
