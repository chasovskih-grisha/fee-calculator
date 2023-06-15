<?php

namespace App\Application\Value;

use App\Application\Value\Interfaces\StringValueInterface;
use App\Application\Value\Interfaces\ValueInterface;

abstract class AbstractStringValue implements StringValueInterface
{
    public function __construct(protected string $value)
    {
        $this->assert();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function eq(ValueInterface $value): bool
    {
        return $this->value === $value->getValue();
    }

    protected function assert(): void
    {

    }
}
