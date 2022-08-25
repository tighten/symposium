<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\ConferenceIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ConferenceIssuesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function saving_a_conference_issue()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('conferences.issues.store', $conference), [
                'reason' => 'spam',
                'note' => 'this conference is spam',
            ]);

        $response->assertRedirect(
            route('conferences.show', $conference),
        );
        $this->assertDatabaseHas('conference_issues', [
            'conference_id' => $conference->id,
            'reason' => 'spam',
            'note' => 'this conference is spam',
        ]);
    }

    /** @test */
    function conference_issues_must_contain_a_reason_and_note()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('conferences.issues.store', $conference), []);

        $response->assertInvalid(['reason', 'note']);
        $this->assertDatabaseMissing('conference_issues', [
            'conference_id' => $conference->id,
        ]);
    }

    /** @test */
    function conference_issue_reasons_must_be_an_expected_value()
    {
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
    }

    /** @test */
    function only_admins_can_view_conference_issues()
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();
        $issue = ConferenceIssue::factory()->create();

        $this->actingAs($admin)
            ->get(route('conferences.issues.show', $issue))
            ->assertSuccessful();

        $this->actingAs($user)
            ->get(route('conferences.issues.show', $issue))
            ->assertNotFound();
    }

    /** @test */
    function admins_can_close_issues()
    {
        $user = User::factory()->admin()->create();
        $issue = ConferenceIssue::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('closed-issues.store', $issue));

        $response->assertRedirect(route('conferences.show', $issue->conference));
        $this->assertNotNull($issue->fresh()->closed_at);
    }

    /** @test */
    function issues_cannot_be_reclosed()
    {
        $user = User::factory()->admin()->create();
        $issue = ConferenceIssue::factory()->closed()->create();
        $closingDate = Carbon::create($issue->closed_at);

        $response = $this->actingAs($user)
            ->post(route('closed-issues.store', $issue));

        $response->assertSessionHasErrors('issue');
        $this->assertEquals((string) $closingDate, $issue->fresh()->closed_at);
    }

    /** @test */
    function non_admins_cannot_close_issues()
    {
        $user = User::factory()->create();
        $issue = ConferenceIssue::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('closed-issues.store', $issue));

        $response->assertNotFound();
        $this->assertNull($issue->fresh()->closed_at);
    }

    /** @test */
    function issues_that_have_not_been_closed_are_open()
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
}
