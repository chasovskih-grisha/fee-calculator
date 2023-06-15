<?php

namespace App\Application\Value\Interfaces;

interface StringValueInterface extends ValueInterface
{
    public function getValue(): string;
    public function __toString(): string;
}
