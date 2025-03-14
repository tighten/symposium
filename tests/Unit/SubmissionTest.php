<?php

namespace Tests\Unit;

use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function scoping_submissions_where_accepted(): void
    {
        $submissionA = Submission::factory()->accepted()->create();
        $submissionB = Submission::factory()->rejected()->create();

        $submissionIds = Submission::accepted()->get()->pluck('id');

        $this->assertContains($submissionA->id, $submissionIds);
        $this->assertNotContains($submissionB->id, $submissionIds);
    }

    #[Test]
    public function scoping_submissions_where_rejected(): void
    {
        $submissionA = Submission::factory()->accepted()->create();
        $submissionB = Submission::factory()->rejected()->create();

        $submissionIds = Submission::rejected()->get()->pluck('id');

        $this->assertContains($submissionB->id, $submissionIds);
        $this->assertNotContains($submissionA->id, $submissionIds);
    }

    #[Test]
    public function getting_an_acceptance_reason(): void
    {
        $submission = Submission::factory()->accepted([
            'reason' => 'Talk is great!',
        ])->create();

        $this->assertEquals('Talk is great!', $submission->reason);
    }

    #[Test]
    public function getting_a_rejection_reason(): void
    {
        $submission = Submission::factory()->rejected([
            'reason' => 'Talk is lousy',
        ])->create();

        $this->assertEquals('Talk is lousy', $submission->reason);
    }
}
