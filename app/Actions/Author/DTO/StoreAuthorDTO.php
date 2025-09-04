<?php

declare(strict_types=1);

namespace App\Actions\Author\DTO;

use App\ValueObjects\Email;

class StoreAuthorDTO
{
    public function __construct(
        public readonly string $name,
        public readonly Email $email,
        public readonly string $description,
    ) {}
}
