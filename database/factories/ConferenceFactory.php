<?php

namespace Database\Factories;

use App\Casts\SpeakerPackage;
use App\Models\Conference;
use App\Models\ConferenceIssue;
use App\Models\Submission;
use App\Models\TalkRevision;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConferenceFactory extends Factory
{
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'title' => 'Dummy Conference',
            'description' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'starts_at' => $this->faker->dateTimeBetween('+3 days', '+10 days'),
            'ends_at' => $this->faker->dateTimeBetween('+11 days', '+20 days'),
            'cfp_starts_at' => $this->faker->dateTimeBetween('-9 days', '-1 day'),
            'cfp_ends_at' => $this->faker->dateTimeBetween('+1 days', '+2 days'),
            'is_approved' => true,
        ];
    }

    public function dates($start, $end = null)
    {
        return $this->state([
            'starts_at' => $start,
            'ends_at' => $end ?? $start,
        ]);
    }

    public function closedCFP()
    {
        return $this->state([
            'cfp_starts_at' => $this->faker->dateTimeBetween('-9 days', '-4 day'),
            'cfp_ends_at' => $this->faker->dateTimeBetween('-3 days', '-1 days'),
        ]);
    }

    public function cfpDates($start, $end = null)
    {
        return $this->state([
            'cfp_starts_at' => $start,
            'cfp_ends_at' => $end ?? $start,
        ]);
    }

    public function noCfpDates()
    {
        return $this->state([
            'cfp_starts_at' => null,
            'cfp_ends_at' => null,
        ]);
    }

    public function approved()
    {
        return $this->state([
            'is_approved' => true,
        ]);
    }

    public function rejected()
    {
        return $this->state([
            'rejected_at' => $this->faker->dateTime,
        ]);
    }

    public function notApproved()
    {
        return $this->state([
            'is_approved' => false,
        ]);
    }

    public function shared()
    {
        return $this->state([
            'is_shared' => true,
        ]);
    }

    public function notShared()
    {
        return $this->state([
            'is_shared' => false,
        ]);
    }

    public function author($author)
    {
        return $this->for($author, 'author');
    }

    public function received(TalkRevision $revision)
    {
        return $this->afterCreating(function (Conference $conference) use ($revision) {
            Submission::factory()
                ->for($conference)
                ->for($revision)
                ->create();
        });
    }

    public function favoritedBy(User $user)
    {
        return $this->afterCreating(function (Conference $conference) use ($user) {
            $user->favoritedConferences()->attach($conference->id);
        });
    }

    public function dismissedBy(User $user)
    {
        return $this->afterCreating(function (Conference $conference) use ($user) {
            $user->dismissedConferences()->attach($conference->id);
        });
    }

    public function withSpeakerPackage()
    {
        $speakerPackage = [
            'currency' => 'usd',
            'travel' => 1000,
            'food' => 1000,
            'hotel' => 1000,
        ];


        return $this->state([
            'speaker_package' => new SpeakerPackage($speakerPackage),
        ]);
    }

    public function withClosedIssue()
    {
        return $this->afterCreating(function ($conference) {
            ConferenceIssue::factory()
                ->closed()
                ->create([
                    'conference_id' => $conference->id,
                ]);
        });
    }
}
