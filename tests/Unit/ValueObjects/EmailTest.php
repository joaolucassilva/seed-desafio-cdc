<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\Exceptions\InvalidEmailException;
use App\ValueObjects\Email;
use Tests\TestCase;

class EmailTest extends TestCase
{
    public function test_it_should_not_create_email_with_empty_value(): void
    {
        $this->expectException(InvalidEmailException::class);
        $this->expectExceptionMessage('Email cannot be empty');

        new Email('');
    }

    public function test_it_should_not_create_email_with_more_than_255_characters(): void
    {
        $this->expectException(InvalidEmailException::class);
        $this->expectExceptionMessage('Email cannot be longer than 255 characters');

        $longEmail = str_repeat('a', 280).'@test.com';
        new Email($longEmail);
    }

    public function test_it_should_not_create_email_with_invalid_format(): void
    {
        $this->expectException(InvalidEmailException::class);
        $this->expectExceptionMessage('Email is not valid');

        new Email('invalid-email');
    }

    public function test_it_should_create_valid_email(): void
    {
        $email = new Email('test@example.com');

        $this->assertEquals('test@example.com', (string) $email);
    }

    public function test_it_should_convert_email_to_lowercase(): void
    {
        $email = new Email('TEST@EXAMPLE.COM');

        $this->assertEquals('test@example.com', (string) $email);
    }
}
