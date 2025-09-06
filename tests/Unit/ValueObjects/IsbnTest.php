<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\Exceptions\InvalidIsbnException;
use App\ValueObjects\Isbn;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class IsbnTest extends TestCase
{
    #[DataProvider('isbnProvider')]
    public function test_validate_isbn(string $isbn, bool $isValid): void
    {
        if (! $isValid) {
            $this->expectException(InvalidIsbnException::class);
        }

        $isbnObject = new Isbn($isbn);
        $this->assertNotEmpty($isbnObject->value());
    }

    public static function isbnProvider(): array
    {
        return [

            'valid ISBN-13' => ['978-0-7475-3269-9', true],
            'valid ISBN harry potter' => ['0-7475-3269-9', true],
            'valid ISBN-13 without dashes' => ['9780747532699', true],
            'valid ISBN-10' => ['0-7475-3269-9', true],
            'valid ISBN-10 with X' => ['0-7475-3269-X', false],
            'invalid ISBN-13 checksum' => ['978-0-7475-3269-0', false],
            'invalid ISBN-10 checksum' => ['0-7475-3269-0', false],
            'invalid format' => ['abc-0-7475-3269-9', false],
            'wrong length' => ['978-0-7475-3269', false],
            'invalid characters' => ['123', false],
            'invalid x' => ['978123456789X', false],
            'empty string' => ['', false],
            'invalid ISBN-10 length' => ['12345678', false],
            'valid format with digits' => ['0123456789', true],
            'invalid format with X' => ['012345678X', false],
            'invalid format too short' => ['012345678', false],
            'invalid format too long' => ['01234567890', false],
            'invalid format with letter' => ['01234A6789', false],
            'invalid X position' => ['0123X56789', false],
        ];
    }
}
