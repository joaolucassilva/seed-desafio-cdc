<?php

declare(strict_types=1);

namespace App\Http\Requests\Author;

use App\Actions\Author\DTO\StoreAuthorDTO;
use App\Exceptions\InvalidEmailException;
use App\ValueObjects\Email;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:authors,email',
            'description' => 'required|string|max:400',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 400 characters.',

            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'email.string' => 'The email must be a string.',
            'email.max' => 'The email may not be greater than 255 characters.',
        ];
    }

    /**
     * @throws InvalidEmailException
     */
    public function toDto(): StoreAuthorDTO
    {
        return new StoreAuthorDTO(
            name: $this->request->get('name'),
            email: new Email($this->request->get('email')),
            description: $this->request->get('description'),
        );
    }
}
