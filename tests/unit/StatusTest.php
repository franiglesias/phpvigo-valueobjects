<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Domain\InvalidStatusChange;
use App\Domain\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class StatusTest extends TestCase
{
    public function testShouldFailWithInvalidStatus(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Status('bad-status');
    }

    public function testShouldAcceptDraftStatus(): void
    {
        $status = new Status('draft');
        $this->assertEquals('draft', $status->status());
    }

    public function testShouldAcceptReviewStatus(): void
    {
        $status = new Status('to review');
        $this->assertEquals('to review', $status->status());
    }

    public function testShouldAcceptPublishedStatus(): void
    {
        $status = new Status('published');
        $this->assertEquals('published', $status->status());
    }

    public function testShouldDisallowPublishFromDraft(): void
    {
        $draft = new Status('draft');
        $this->expectException(InvalidStatusChange::class);
        $draft->publish();
    }

    public function testShouldAllowPublishFromReview(): void
    {
        $review = new Status('to review');
        $published = $review->publish();

        $this->assertEquals('published',$published->status() );
    }

    public function testShouldAllowReviewFromDraft(): void
    {
        $draft = new Status('draft');
        $review = $draft->review();

        $this->assertEquals('to review', $review->status());
    }

    public function testDraftShouldBeCreatedWithFactory(): void
    {
        $draft = Status::draft();
        $this->assertEquals('draft', $draft->status());
    }

    public function testToReviewShouldBeCreatedWithFactory(): void
    {
        $review = Status::toReview();
        $this->assertEquals('to review', $review->status());
    }

    public function testPublishedShouldBeCreatedWithFactory(): void
    {
        $published = Status::published();
        $this->assertEquals('published', $published->status());
    }

    public function testShouldAnswerToIsPublished(): void
    {
        $published = Status::published();
        $this->assertTrue($published->isPublished());
    }

    public function testShouldAnswerToIsReview(): void
    {
        $toReview = Status::toReview();
        $this->assertTrue($toReview->isReview());
    }

}
