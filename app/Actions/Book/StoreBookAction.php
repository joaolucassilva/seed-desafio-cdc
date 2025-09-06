<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Book\DTO\StoreBookDTO;
use App\Exceptions\AuthorNotFound;
use App\Exceptions\CategoryNotFound;
use App\Exceptions\DuplicateBookTitleException;
use App\Exceptions\DuplicateIsbnException;
use App\Exceptions\InvalidBookResumeException;
use App\Exceptions\InvalidBookTitleException;
use App\Exceptions\InvalidNumberPagesException;
use App\Exceptions\InvalidPriceException;
use App\Exceptions\InvalidPublicationDateException;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

class StoreBookAction
{
    public function __construct(
        private readonly Book $book,
        private readonly Author $author,
        private readonly Category $category,
    ) {}

    /**
     * @throws AuthorNotFound
     * @throws CategoryNotFound
     * @throws DuplicateBookTitleException
     * @throws DuplicateIsbnException
     * @throws InvalidPublicationDateException
     * @throws InvalidNumberPagesException
     * @throws InvalidPriceException
     * @throws InvalidBookResumeException
     * @throws InvalidBookTitleException
     */
    public function __invoke(StoreBookDTO $input): void
    {
        $existingTitle = $this->book->newQuery()->where('title', $input->title)->exists();
        $existingIsbn = $this->book->newQuery()->where('isbn', $input->isbn->value())->exists();

        if ($existingTitle) {
            throw new DuplicateBookTitleException('Title already exists');
        }

        if ($existingIsbn) {
            throw new DuplicateIsbnException('ISBN already exists');
        }

        if (empty($input->title)) {
            throw new InvalidBookTitleException('Title is required');
        }

        if (empty($input->resume) || strlen($input->resume) > 500) {
            throw new InvalidBookResumeException('Resume is required and must not exceed 500 characters');
        }

        if ($input->price->amount() < 2000) {
            throw new InvalidPriceException('Price must be at least 20');
        }

        if ($input->numberPages < 100) {
            throw new InvalidNumberPagesException('Number of pages must be at least 100');
        }

        if ($input->publicationDate <= new \DateTimeImmutable) {
            throw new InvalidPublicationDateException('Publication date must be in the future');
        }

        $author = $this->author->newQuery()->where('id', $input->authorId)->first();
        if (! $author) {
            throw new AuthorNotFound('Author is required');
        }

        $category = $this->category->newQuery()->where('id', $input->categoryId)->first();
        if (! $category) {
            throw new CategoryNotFound('Category is required');
        }

        $this->book->newQuery()->create([
            'title' => $input->title,
            'resume' => $input->resume,
            'summary' => $input->summary,
            'price' => $input->price->amount(),
            'number_pages' => $input->numberPages,
            'isbn' => (string) $input->isbn,
            'publication_date' => $input->publicationDate,
            'author_id' => $author->id,
            'category_id' => $category->id,
        ]);
    }
}
