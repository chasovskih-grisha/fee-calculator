<?php

namespace App\Application\Value\Interfaces;

interface ValueInterface
{
    public function getValue();
    public function eq(ValueInterface $value): bool;
}
