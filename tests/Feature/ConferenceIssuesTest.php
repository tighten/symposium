<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\ConferenceIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
