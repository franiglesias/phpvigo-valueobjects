<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Domain\Location;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class LocationTest extends TestCase
{
    public function testShouldNotAcceptLongGreaterThan180(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid longitude');
        new Location(181, 0);
    }

    public function testShouldNotAcceptLongLowerThanNegative180(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid longitude');
        new Location(-181, 0);
    }

    public function testShouldNotAcceptLatGreaterThan90(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid latitude');
        new Location(0, 91);
    }

    public function testShouldNotAcceptLatLowerThanNegative90(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid latitude');
        new Location(0, -91);
    }

    public function testShouldAcceptLocation00(): void
    {
        $location = new Location(0, 0);
        $this->assertEquals(0, $location->long());
        $this->assertEquals(0, $location->lat());
    }

    public function testShouldAcceptArbitraryLocation(): void
    {
        $location = new Location(-8.72, 42.23);
        $this->assertEquals(-8.72, $location->long());
        $this->assertEquals(42.23, $location->lat());
    }

    public function testShouldMoveImmutable(): void
    {
        $vigo = new Location(-8.72, 42.23);
        $ourense = $vigo->move(0.86, 0.10);
        $this->assertNotSame($vigo, $ourense);

        $this->assertEquals(-8.72, $vigo->long());
        $this->assertEquals(42.23, $vigo->lat());

        $this->assertEquals(-7.86, $ourense->long());
        $this->assertEquals(42.33, $ourense->lat());

    }

}
