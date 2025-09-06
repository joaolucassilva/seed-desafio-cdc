<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Money;
use InvalidArgumentException;
use Tests\TestCase;

class MoneyTest extends TestCase
{
    public function test_it_creates_money_object_successfully(): void
    {
        $money = new Money(1000);
        $this->assertInstanceOf(Money::class, $money);
    }

    public function test_it_throws_exception_for_negative_amount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount cannot be negative.');
        new Money(-100);
    }

    public function test_it_returns_amount(): void
    {
        $money = new Money(1000);
        $this->assertEquals(1000, $money->amount());
    }

    public function test_it_converts_to_float(): void
    {
        $money = new Money(1000);
        $this->assertEquals(10.0, $money->toFloat());
    }

    public function test_it_converts_to_string(): void
    {
        $money = new Money(1000);
        $this->assertEquals('10,00', (string) $money);
    }
}
