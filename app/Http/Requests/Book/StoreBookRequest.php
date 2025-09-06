<?php

declare(strict_types=1);

namespace App\Http\Requests\Book;

use App\Actions\Book\DTO\StoreBookDTO;
use App\ValueObjects\Isbn;
use App\ValueObjects\Money;
use DateMalformedStringException;
use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:books,title',
            'resume' => 'required|string|max:500',
            'summary' => 'nullable|string',
            'price' => 'required|integer|min:2000',
            'number_pages' => 'required|integer|min:100',
            'isbn' => 'required|string|unique:books,isbn',
            'publication_date' => 'required|date',
            'author_id' => 'required',
            'category_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'The title has already been taken.',
            'resume.required' => 'The resume field is required.',
            'resume.string' => 'The resume must be a string.',
            'resume.max' => 'The resume may not be greater than 500 characters.',
            'summary.string' => 'The summary must be a string.',
            'price.required' => 'The price field is required.',
            'price.integer' => 'The price must be an integer.',
            'price.min' => 'The price must be at least 2000.',
            'number_pages.required' => 'The number pages field is required.',
            'number_pages.integer' => 'The number pages must be an integer.',
            'number_pages.min' => 'The number pages must be at least 100.',
            'isbn.required' => 'The isbn field is required.',
            'isbn.string' => 'The isbn must be a string.',
            'isbn.max' => 'The isbn may not be greater than 13 characters.',
            'isbn.unique' => 'The isbn has already been taken.',
            'publication_date.required' => 'The publication date field is required.',
            'publication_date.date' => 'The publication date must be a valid date.',
            'author_id.required' => 'The author id field is required.',
            'category_id.required' => 'The category id field is required.',
        ];
    }

    /**
     * @throws DateMalformedStringException
     */
    public function toDto(): StoreBookDTO
    {
        return new StoreBookDTO(
            $this->input('title'),
            $this->input('resume'),
            $this->input('summary'),
            new Money((int) $this->input('price')),
            (int) $this->input('number_pages'),
            new Isbn($this->input('isbn')),
            DateTimeImmutable::createFromFormat('Y-m-d', $this->input('publication_date')),
            $this->input('author_id'),
            $this->input('category_id'),
        );
    }
}
