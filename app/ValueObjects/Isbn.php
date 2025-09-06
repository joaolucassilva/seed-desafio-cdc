<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidIsbnException;

final readonly class Isbn
{
    private string $value;

    /**
     * @throws InvalidIsbnException
     */
    public function __construct(string $isbn)
    {
        $clean = str_replace(['-', ' '], '', strtoupper($isbn));
        match (strlen($clean)) {
            10 => $this->isValidIsbn10($clean),
            13 => $this->isValidIsbn13($clean),
            default => throw new InvalidIsbnException('ISBN must be 10 or 13 digits long.'),
        };

        $this->value = $clean;
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @throws InvalidIsbnException
     */
    private function isValidIsbn10(string $value): void
    {
        if (! preg_match('/^\d{9}[\dX]$/', $value)) {
            throw new InvalidIsbnException("ISBN-10 must have 9 digits plus a digit or 'X'.");
        }

        $clean = strtoupper(preg_replace('/[^0-9Xx]/', '', trim($value)));

        $sum = 0;
        // primeiros 9 devem ser dígitos
        for ($i = 0; $i < 9; $i++) {
            if (! ctype_digit($clean[$i])) {
                throw new InvalidIsbnException('Invalid ISBN-10 digit');
            }
            $sum += (int) $clean[$i] * (10 - $i);
        }

        // último: pode ser dígito ou 'X' (valendo 10)
        $check = $clean[9];
        if ($check === 'X') {
            $sum += 10;
        } elseif (ctype_digit($check)) {
            $sum += (int) $check;
        } else {
            throw new InvalidIsbnException('Invalid ISBN-10 check digit');
        }

        if (($sum % 11 === 0) === false) {
            throw new InvalidIsbnException('Invalid ISBN-10 check digit.');
        }
    }

    /**
     * @throws InvalidIsbnException
     */
    private function isValidIsbn13(string $value): void
    {
        if (! preg_match('/^\d{13}$/', $value)) {
            throw new InvalidIsbnException('ISBN-13 must have 13 digits.');
        }
        $value = preg_replace('/\D/', '', $value);

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $value[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }

        $check = (10 - ($sum % 10)) % 10;

        if (($check === (int) $value[12]) === false) {
            throw new InvalidIsbnException('Invalid ISBN-13 check digit.');
        }
    }
}
