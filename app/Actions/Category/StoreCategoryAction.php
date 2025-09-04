<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Exceptions\CategoryException;
use App\Exceptions\CategoryNameInvalid;
use App\Models\Category;

class StoreCategoryAction
{
    public function __construct(
        private readonly Category $categoryModel,
    ) {}

    /**
     * @throws CategoryNameInvalid
     * @throws CategoryException
     */
    public function __invoke(string $name): void
    {
        if ($name === '') {
            throw new CategoryNameInvalid('Category Name cannot be empty');
        }

        $categoryExists = $this->categoryModel
            ->newQuery()
            ->where('name', $name)
            ->first();
        if ($categoryExists !== null) {
            throw new CategoryException('Category already exists');
        }

        $this->categoryModel
            ->newQuery()
            ->create([
                'name' => $name,
            ]);
    }
}
