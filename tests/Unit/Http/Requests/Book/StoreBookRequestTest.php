<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Book;

use App\Http\Requests\Book\StoreBookRequest;
use Tests\TestCase;

class StoreBookRequestTest extends TestCase
{
    private StoreBookRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new StoreBookRequest;
    }

    public function test_authorize(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function test_rules(): void
    {
        $this->assertEquals([
            'title' => 'required|string|max:255|unique:books,title',
            'resume' => 'required|string|max:500',
            'summary' => 'nullable|string',
            'price' => 'required|integer|min:2000',
            'number_pages' => 'required|integer|min:100',
            'isbn' => 'required|string|unique:books,isbn',
            'publication_date' => 'required|date',
            'author_id' => 'required',
            'category_id' => 'required',
        ], $this->request->rules());
    }

    public function test_messages(): void
    {
        $this->assertEquals([
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
        ], $this->request->messages());
    }
}
