<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;
use phpDocumentor\Reflection\Types\Self_;

class Status
{
    private const DRAFT = 'draft';
    private const TO_REVIEW = 'to review';
    private const PUBLISHED = 'published';

    private const VALID_STATUSES = [
        self::DRAFT,
        self::TO_REVIEW,
        self::PUBLISHED
    ];
    /** @var string */
    private string $status;

    public function __construct(string $status)
    {
        if (!in_array($status, self::VALID_STATUSES, true)) {
            throw new InvalidArgumentException('Bad Status');
        }
        $this->status = $status;
    }

    public static function draft(): self
    {
        return new self(self::DRAFT);
    }

    public static function toReview(): self
    {
        return new self(self::TO_REVIEW);
    }

    public static function published(): self
    {
        return new self(self::PUBLISHED);
    }

    public function status(): string
    {
        return $this->status;
    }

    public function publish(): Status
    {
        if ($this->status() === self::DRAFT) {
            throw new InvalidStatusChange(
                sprintf(
                    'Forbidden operation %s to published', $this->status()
                )
            );
        }

        return new Status(self::PUBLISHED);
    }

    public function review(): Status
    {
        return new Status(self::TO_REVIEW);
    }

    public function isPublished(): bool
    {
        return $this->equals(self::published());
    }

    public function equals(Status $otherStatus): bool
    {
        return $this->status() === $otherStatus->status();
    }

    public function isReview(): bool
    {
        return $this->equals(self::toReview());
    }
}
