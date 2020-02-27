<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Domain\Customer;
use App\Domain\InvalidStatusChange;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CustomerTest extends TestCase
{
    public function testShouldCreateValidOnDraftState(): void
    {
        $customer = new Customer(
            'Fran',
            'Iglesias',
            'Gómez',
            'franiglesias@mac.com',
            'Vigo',
            -8.72,
            42.23
        );

        $this->assertEquals('Fran Iglesias Gómez', $customer->fullName());
        $this->assertEquals('draft', $customer->status());
    }

    public function testShouldFailWithIncompleteName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Customer(
            '',
            'Iglesias',
            'Gómez',
            'franiglesias@mac.com',
            'Vigo',
            -8.72,
            42.23
        );
    }

    public function testShouldFailWithInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Customer(
            'Fran',
            'Iglesias',
            'Gómez',
            'franiglesias@',
            'Vigo',
            -8.72,
            42.23
        );
    }

    public function testShouldFailWithoutLocationName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Customer(
            'Fran',
            'Iglesias',
            'Gómez',
            'franiglesias@mac.com',
            '',
            -8.72,
            42.23
        );
    }

    public function testShouldFailWithBadLocations(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Customer(
            'Fran',
            'Iglesias',
            'Gómez',
            'franiglesias@mac.com',
            '',
            210,
            42.23
        );
    }


    public function testShouldFailIfConfirmCustomerWithOtherStatusThanDraft(): void
    {
        $customer = new Customer(
            'Fran',
            'Iglesias',
            'Gómez',
            'franiglesias@mac.com',
            'Vigo',
            -8.72,
            42.23
        );

        $customer->setStatus('to review');

        $this->expectException(InvalidStatusChange::class);
        $customer->confirm();
    }


    public function testShouldPromoteToReviewWhenConfirmed(): void
    {
        $customer = new Customer(
            'Fran',
            'Iglesias',
            'Gómez',
            'franiglesias@mac.com',
            'Vigo',
            -8.72,
            42.23
        );

        $customer->confirm();

        $this->assertEquals('to review', $customer->status());
    }

}
