<?php

declare(strict_types=1);

namespace App\Actions\Author;

use App\Actions\Author\DTO\StoreAuthorDTO;
use App\Exceptions\AuthorException;
use App\Models\Author;

readonly class StoreAuthorAction
{
    public function __construct(
        private Author $author,
    ) {}

    /**
     * @throws AuthorException
     */
    public function __invoke(StoreAuthorDTO $input): void
    {
        $author = $this->author
            ->newQuery()
            ->where('email', $input->email->value())
            ->first();
        if ($author !== null) {
            throw new AuthorException('Author already exists');
        }

        $this->author
            ->newQuery()
            ->create([
                'name' => $input->name,
                'email' => $input->email->value(),
                'description' => $input->description,
            ]);
    }
}
