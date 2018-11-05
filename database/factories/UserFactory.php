<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'enabledNotifications', function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
        'enable_notifications' => true
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
        'approved' => false,
    ];
});

$factory->state(App\Conference::class, 'closedCFP', function (Faker $faker) {
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
        'cfp_ends_at' => $faker->dateTimeBetween('-3 days', '+2 days'),
    ];
});

$factory->state(App\Conference::class, 'noCFPDates', function (Faker $faker) {
    return [
        'author_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'title' => 'Dummy Conference',
        'description' => $faker->sentence,
        'url' => $faker->domainName,
        'starts_at' => $faker->dateTimeBetween('+3 days', '+10 days'),
        'ends_at' => $faker->dateTimeBetween('+11 days', '+20 days'),
    ];
});

$factory->define(App\Talk::class, function (Faker $faker) {
    return [
        'author_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\TalkRevision::class, function (Faker $faker) {
    return [
        'title' => 'My Awesome Title',
        'type' => 'lightning',
        'length' => '9',
        'level' => 'beginner',
        'slides' => 'http://speakerdeck.com/mattstauffer/the-best-talk-ever',
        'description' => 'The best talk ever!',
        'organizer_notes' => 'No really.',
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
