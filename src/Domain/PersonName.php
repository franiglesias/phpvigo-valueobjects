<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

class PersonName
{
    private string $name;
    private string $firstSurname;
    private ?string $secondSurname;

    public function __construct(string $name, string $firstSurname, ?string $secondSurname = null)
    {
        if (!$name || !$firstSurname) {
            throw new InvalidArgumentException('A Person should have name');
        }
        $this->name = $name;
        $this->firstSurname = $firstSurname;
        $this->secondSurname = $secondSurname;
    }

    public function fullName(): string
    {
        $pieces = [$this->name, $this->firstSurname];
        if ($this->secondSurname) {
            $pieces[] = $this->secondSurname;
        }
        return implode(' ', $pieces);
    }
}
