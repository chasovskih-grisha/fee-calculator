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
            $commandTester->getDisplay(),
        );
    }
}
