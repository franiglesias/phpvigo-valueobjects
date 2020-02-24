<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

use function filter_var;

use const FILTER_VALIDATE_EMAIL;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if ((! filter_var($email, FILTER_VALIDATE_EMAIL))) {
            throw new InvalidArgumentException('Bad email: '.$email);
        }

        $this->email = $email;
    }

    public static function fromString(string $rawEmail): self
    {
        return new self($rawEmail);
    }

    public function email(): string
    {
        return $this->email;
    }

    public function equals(Email $emailToCompare): bool
    {
        return $this->email() === $emailToCompare->email();
    }
}
