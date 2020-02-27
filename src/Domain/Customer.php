<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

use function abs;
use function filter_var;
use function implode;

use const FILTER_VALIDATE_EMAIL;

class Customer
{
    private string $name;
    private string $firstSurname;
    private ?string $secondSurname;
    private string $email;
    private string $locationName;
    private float $locationLongitude;
    private float $locationLatitude;
    private string $status;

    public function __construct(
        string $name,
        string $firstSurname,
        ?string $secondSurname,
        string $email,
        string $locationName,
        float $locationLongitude,
        float $locationLatitude
    ) {
        if (!$name || !$firstSurname) {
            throw new InvalidArgumentException('Bad name');
        }

        if ((! filter_var($email, FILTER_VALIDATE_EMAIL))) {
            throw new InvalidArgumentException('Bad email: '.$email);
        }

        if (!$locationName) {
            throw new InvalidArgumentException('No location name provided');
        }

        if (abs($locationLongitude) > 180) {
            throw new InvalidArgumentException('Invalid longitude');
        }
        if (abs($locationLatitude) > 90) {
            throw new InvalidArgumentException('Invalid latitude');
        }

        $this->name = $name;
        $this->firstSurname = $firstSurname;
        $this->secondSurname = $secondSurname;
        $this->email = $email;
        $this->locationName = $locationName;
        $this->locationLongitude = $locationLongitude;
        $this->locationLatitude = $locationLatitude;
        $this->status = 'draft';
    }

    public function fullName(): string
    {
        $pieces = [$this->name, $this->firstSurname];
        if ($this->secondSurname) {
            $pieces[] = $this->secondSurname;
        }
        return implode(' ', $pieces);
    }

    public function status(): string
    {
        return $this->status;
    }

    public function confirm(): void
    {
        if ($this->status !== 'draft') {
            throw new InvalidStatusChange('Invalid status to confirm. Should be draft.');
        }

        $this->status = 'to review';
    }

    public function setStatus(string $newStatus): void
    {
        $this->status = $newStatus;
    }

}
