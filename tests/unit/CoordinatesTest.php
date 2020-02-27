<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Domain\Coordinates;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CoordinatesTest extends TestCase
{
    public function testShouldNotAcceptLongGreaterThan180(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid longitude');
        new Coordinates(181, 0);
    }

    public function testShouldNotAcceptLongLowerThanNegative180(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid longitude');
        new Coordinates(-181, 0);
    }

    public function testShouldNotAcceptLatGreaterThan90(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid latitude');
        new Coordinates(0, 91);
    }

    public function testShouldNotAcceptLatLowerThanNegative90(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid latitude');
        new Coordinates(0, -91);
    }

    public function testShouldAcceptLocation00(): void
    {
        $coordinates = new Coordinates(0, 0);
        $this->assertEquals(0, $coordinates->long());
        $this->assertEquals(0, $coordinates->lat());
    }

    public function testShouldAcceptArbitraryLocation(): void
    {
        $coordinates = new Coordinates(-8.72, 42.23);
        $this->assertEquals(-8.72, $coordinates->long());
        $this->assertEquals(42.23, $coordinates->lat());
    }

    public function testShouldMoveImmutable(): void
    {
        $vigo = new Coordinates(-8.72, 42.23);
        $ourense = $vigo->move(0.86, 0.10);
        $this->assertNotSame($vigo, $ourense);

        $this->assertEquals(-8.72, $vigo->long());
        $this->assertEquals(42.23, $vigo->lat());

        $this->assertEquals(-7.86, $ourense->long());
        $this->assertEquals(42.33, $ourense->lat());
    }

    public function testShouldBeEquatable(): void
    {
        $vigo = new Coordinates(-8.72, 42.23);
        $ourense = $vigo->move(0.86, 0.10);

        $this->assertTrue($vigo->equals($vigo));
    }

}
