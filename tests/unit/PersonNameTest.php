<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Domain\PersonName;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class PersonNameTest extends TestCase
{
    public function testShouldFailIfEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new PersonName('', 'Apellido');
    }

    public function testShouldAcceptNameWithSurname(): void
    {
        $name = new PersonName('Nombre', 'Apellido');
        $this->assertEquals('Nombre Apellido', $name->fullName());
    }

    public function testShouldAllowNameWithTwoSurnames(): void
    {
        $name = new PersonName('Nombre', 'Apellido1', 'Apellido2');
        $this->assertEquals('Nombre Apellido1 Apellido2', $name->fullName());
    }

    public function testShouldFailIfEmptyFirstSurname(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new PersonName('Name', '', 'Apellido2');
    }

}
