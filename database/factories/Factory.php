<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = Hash::make('password'),
        'remember_token' => Str::random(10),
    ];
});

$factory->state(App\User::class, 'wantsNotifications', function () {
    return [
        'wants_notifications' => true,
    ];
});

$factory->state(App\User::class, 'admin', function () {
    return [
        'role' => User::ADMIN_ROLE,
    ];
});

$factory->define(App\Conference::class, function (Faker $faker) {
    return [
        'author_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'title' => 'Dummy Conference',
        'description' => $faker->sentence,
        'url' => $faker->domainName,
        'starts_at' => $faker->dateTimeBetween('+3 days', '+10 days'),
        'ends_at' => $faker->dateTimeBetween('+11 days', '+20 days'),
        'cfp_starts_at' => $faker->dateTimeBetween('-9 days', '-1 day'),
        'cfp_ends_at' => $faker->dateTimeBetween('+1 days', '+2 days'),
        'is_approved' => false,
    ];
});

$factory->state(App\Conference::class, 'closedCFP', function (Faker $faker) {
    return [
        'cfp_starts_at' => $faker->dateTimeBetween('-9 days', '-4 day'),
        'cfp_ends_at' => $faker->dateTimeBetween('-3 days', '-1 days'),
    ];
});

$factory->state(App\Conference::class, 'noCFPDates', function () {
    return [
        'cfp_starts_at' => null,
        'cfp_ends_at' => null,
    ];
});

$factory->state(App\Conference::class, 'approved', function () {
    return [
        'is_approved' => true,
    ];
});

$factory->define(App\Talk::class, function () {
    return [
        'author_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\TalkRevision::class, function () {
    return [
        'title' => 'My Awesome Title',
        'type' => 'lightning',
        'length' => '9',
        'level' => 'beginner',
        'slides' => 'http://speakerdeck.com/mattstauffer/the-best-talk-ever',
        'description' => 'The best talk ever!',
        'organizer_notes' => 'No really.',
        'talk_id' => function () {
            return factory(App\Talk::class)->create()->id;
        },
    ];
});

$factory->define(App\Bio::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'nickname' => 'short',
        'body' => $faker->sentence(),
    ];
});

$factory->define(App\Submission::class, function () {
    return [
        'talk_revision_id' => function () {
            return factory(App\TalkRevision::class)->create()->id;
        },
        'conference_id' => function () {
            return factory(App\Conference::class)->create()->id;
        },
    ];
});

$factory->define(App\Acceptance::class, function () {
    return [
        'talk_revision_id' => function () {
            return factory(App\TalkRevision::class)->create()->id;
        },
        'conference_id' => function () {
            return factory(App\Conference::class)->create()->id;
        },
    ];
});
