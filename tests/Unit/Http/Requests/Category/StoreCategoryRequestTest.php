<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Category;

use App\Http\Requests\Category\StoreCategoryRequest;
use Tests\TestCase;

class StoreCategoryRequestTest extends TestCase
{
    private StoreCategoryRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new StoreCategoryRequest();
    }

    public function test_authorize(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function test_rules(): void
    {
        $this->assertEquals([
            'name' => 'required|string|max:255|unique:categories,name',
        ], $this->request->rules());
    }

    public function test_messages(): void
    {
        $this->assertEquals([
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
        ], $this->request->messages());
    }
}
