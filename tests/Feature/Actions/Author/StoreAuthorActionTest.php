<?php

declare(strict_types=1);

namespace Feature\Actions\Author;

use App\Actions\Author\DTO\StoreAuthorDTO;
use App\Actions\Author\StoreAuthorAction;
use App\Exceptions\AuthorException;
use App\Exceptions\InvalidEmailException;
use App\Models\Author;
use App\ValueObjects\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreAuthorActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws AuthorException
     */
    public function test_create_author_with_success(): void
    {
        $authorModel = new Author;
        $input = new StoreAuthorDTO(
            name: 'Test',
            email: new Email('test@gmail.com'),
            description: 'Test description',
        );
        $action = new StoreAuthorAction($authorModel);
        $action->__invoke($input);

        $this->assertDatabaseCount('authors', 1);
    }

    /**
     * @throws AuthorException
     * @throws InvalidEmailException
     */
    public function test_create_author_when_author_exist(): void
    {
        $this->expectException(AuthorException::class);

        $author = Author::factory()->create();

        $authorModel = new Author;
        $input = new StoreAuthorDTO(
            name: 'Test',
            email: new Email($author->email),
            description: 'Test description',
        );
        $action = new StoreAuthorAction($authorModel);
        $action->__invoke($input);
    }
}
