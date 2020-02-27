<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

class Location
{

    private string $name;
    private Coordinates $coordinates;

    public function __construct(string $name, Coordinates $coordinates)
    {
        if (!$name) {
            throw new InvalidArgumentException('No location name provided');
        }
        $this->name = $name;
        $this->coordinates = $coordinates;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function coordinates(): Coordinates
    {
        return $this->coordinates;
    }
}
