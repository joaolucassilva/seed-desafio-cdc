<?php

declare(strict_types=1);

namespace App\ValueObjects;

use InvalidArgumentException;

final readonly class Money
{
    private int $amount;

    public function __construct(
        int $amount,
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException('Amount cannot be negative.');
        }

        $this->amount = $amount;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function toFloat(): float
    {
        return $this->amount / 100;
    }

    public function __toString(): string
    {
        return number_format($this->toFloat(), 2, ',', '.');
    }
}
