<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\ConferenceIssue;
use App\Models\User;
use App\Notifications\ConferenceIssueReported;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConferenceIssuesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function creating_a_conference_issue()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('conferences.issues.create', $conference));

        $response->assertSuccessful();
    }

    #[Test]
    public function saving_a_conference_issue(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $conference = Conference::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('conferences.issues.store', $conference), [
                'reason' => 'spam',
                'note' => 'this conference is spam',
            ]);

        $response->assertRedirect(route('conferences.show', $conference));

        tap($conference->issues->first(), function ($issue) use ($user) {
            $this->assertNotNull($issue);
            $this->assertTrue($issue->user->is($user));
            $this->assertEquals('spam', $issue->reason);
            $this->assertEquals('this conference is spam', $issue->note);
        });

        Notification::assertSentToTightenSlack(ConferenceIssueReported::class);
    }

    #[Test]
    public function conference_issues_must_contain_a_reason_and_note(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $conference = Conference::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('conferences.issues.store', $conference), []);

        $response->assertInvalid(['reason', 'note']);
        $this->assertDatabaseMissing('conference_issues', [
            'conference_id' => $conference->id,
        ]);
        Notification::assertNothingSent();
    }

    #[Test]
    public function conference_issue_reasons_must_be_an_expected_value(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $conference = Conference::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('conferences.issues.store', $conference), [
                'reason' => 'dislike',
                'note' => 'I just dislike it',
            ]);

        $response->assertInvalid(['reason']);
        $this->assertDatabaseMissing('conference_issues', [
            'conference_id' => $conference->id,
        ]);
        Notification::assertNothingSent();
    }

    #[Test]
    public function issues_that_have_not_been_closed_are_open(): void
    {
        $openIssue = ConferenceIssue::factory()->create([
            'closed_at' => null,
        ]);
        $closedIssue = ConferenceIssue::factory()->create([
            'closed_at' => now(),
        ]);

        $this->assertTrue($openIssue->isOpen());
        $this->assertFalse($closedIssue->isOpen());
    }

    #[Test]
    public function closing_an_issue(): void
    {
        $user = User::factory()->create();
        $issue = ConferenceIssue::factory()->create();
        $this->assertTrue($issue->isOpen());

        $issue->close($user, 'This conference is spam');

        tap($issue->fresh(), function ($issue) use ($user) {
            $this->assertEquals($user->id, $issue->closed_by);
            $this->assertEquals('This conference is spam', $issue->admin_note);
            $this->assertNotNull($issue->closed_at);
        });
    }
}
