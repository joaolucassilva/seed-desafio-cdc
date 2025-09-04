<?php

declare(strict_types=1);

namespace Feature\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category_with_success(): void
    {
        $this->postJson(route('categories.store'), [
            'name' => 'Test',
        ])->assertStatus(Response::HTTP_OK);
    }

    public function test_create_category_with_error_name_body_is_empty(): void
    {
        $this->postJson(route('categories.store'), [
            'name' => '',
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ]
                ],
                'message' => 'The name field is required.'
            ]);
    }

    public function test_create_category_with_error_name_already_exists(): void
    {
        Category::factory()->create(['name' => 'Test']);

        $this->postJson(route('categories.store'), [
            'name' => 'Test',
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
