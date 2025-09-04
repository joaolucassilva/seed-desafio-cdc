<?php

declare(strict_types=1);

namespace Feature\Actions\Category;

use App\Actions\Category\StoreCategoryAction;
use App\Exceptions\CategoryException;
use App\Exceptions\CategoryNameInvalid;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCategoryActionTest extends TestCase
{
    use RefreshDatabase;

    private Category $categoryModel;

    private StoreCategoryAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $categoryModel = new Category;
        $this->action = new StoreCategoryAction($categoryModel);
    }

    /**
     * @throws CategoryNameInvalid
     * @throws CategoryException
     */
    public function test_create_category_with_success(): void
    {
        $this->action->__invoke('Test');

        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', ['name' => 'Test']);
    }

    /**
     * @throws CategoryException
     */
    public function test_create_category_with_error_when_name_is_empty(): void
    {
        $this->expectException(CategoryNameInvalid::class);
        $this->action->__invoke('');
    }

    public function test_create_category_with_error_when_name_already_exists(): void
    {
        Category::factory()->create(['name' => 'Test']);
        $this->expectException(CategoryException::class);
        $this->action->__invoke('Test');
    }
}
