<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidEmailException extends Exception
{
    protected $message = 'Invalid email address provided';

    protected $code = 422;

    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message ?: $this->message, $code ?: $this->code);
    }
}
