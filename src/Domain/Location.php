<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

use function abs;

class Location
{
    private float $long;
    private float $lat;

    public function __construct(float $long, float $lat)
    {
        if (abs($long) > 180) {
            throw new InvalidArgumentException('Invalid longitude');
        }
        if (abs($lat) > 90) {
            throw new InvalidArgumentException('Invalid latitude');
        }

        $this->long = $long;
        $this->lat = $lat;
    }

    public function long(): float
    {
        return $this->long;
    }

    public function lat(): float
    {
        return $this->lat;
    }

    public function move(float $deltaLong, float $deltaLat): Location
    {
        $newLong = $this->long() + $deltaLong;
        $newLat = $this->lat() + $deltaLat;

        return new self($newLong, $newLat);
    }
}
