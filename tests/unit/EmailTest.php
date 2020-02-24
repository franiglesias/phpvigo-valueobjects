<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Domain\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testShouldFailWithMalformedEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('@example.com');
    }

    public function testShouldAcceptAValidEmail(): void
    {
        $email = new Email('user@example.com');
        $this->assertEquals('user@example.com', $email->email());
    }

    public function testShouldCheckForNotEquality(): void
    {
        $email = new Email('user@example.com');
        $emailToCompare = new Email('other@example.org');
        $this->assertFalse($email->equals($emailToCompare));
    }
    public function testShouldCheckForEquality(): void
    {
        $email = new Email('user@example.com');
        $emailToCompare = new Email('user@example.com');
        $this->assertTrue($email->equals($emailToCompare));
    }

    public function testShouldBeCreatedWithFactoryMethod(): void
    {
        $email = Email::fromString('user@example.com');
        $this->assertEquals('user@example.com', $email->email());
    }

}
