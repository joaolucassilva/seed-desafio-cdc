<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'resume' => $this->faker->paragraph(),
            'summary' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(2000, 10000),
            'number_pages' => $this->faker->numberBetween(100, 1000),
            'isbn' => $this->faker->isbn13(),
            'publication_date' => $this->faker->date(),
            'author_id' => Author::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
