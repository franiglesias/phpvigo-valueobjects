<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Domain\Coordinates;
use App\Domain\Location;
use PHPUnit\Framework\TestCase;

final class LocationTest extends TestCase
{
    public function testShouldInstantiate(): void
    {
        $coords = new Coordinates(-8.72, 42.23);
        $vigo = new Location('Vigo', $coords);

        $this->assertTrue($vigo->coordinates()->equals($coords));
        $this->assertEquals('Vigo', $vigo->name());
    }

}
