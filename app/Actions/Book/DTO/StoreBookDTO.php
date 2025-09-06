<?php

declare(strict_types=1);

namespace App\Actions\Book\DTO;

use App\ValueObjects\Isbn;
use App\ValueObjects\Money;
use DateTimeImmutable;

class StoreBookDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $resume,
        public readonly string $summary,
        public readonly Money $price,
        public readonly int $numberPages,
        public readonly Isbn $isbn,
        public readonly DateTimeImmutable $publicationDate,
        public readonly int $authorId,
        public readonly int $categoryId,
    ) {}
}
