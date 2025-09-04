<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidEmailException;
use Illuminate\Support\Stringable;

class Email extends Stringable
{
    /**
     * @throws InvalidEmailException
     */
    public function __construct(protected $value = '')
    {
        $value = strtolower(trim($value));
        $this->ensureEmailIsValid($value);

        parent::__construct($value);
    }

    /**
     * @throws InvalidEmailException
     */
    private function ensureEmailIsValid(string $email): void
    {
        if (empty($email)) {
            throw new InvalidEmailException('Email cannot be empty');
        }

        if (strlen($email) > 255) {
            throw new InvalidEmailException('Email cannot be longer than 255 characters');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidEmailException('Email is not valid');
        }
    }
}
