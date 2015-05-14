<?php

$factory('Conference', 'conference', [
    'author_id' => 1,
    'title' => 'Dummy Conference',
    'description' => 'A conference for dummies.',
    'url' => 'http://example.com',
    'starts_at' => new DateTime,
    'ends_at' => new DateTime,
    'cfp_starts_at' => new DateTime,
    'cfp_ends_at' => new DateTime,
]);

$factory('User', 'user', [
    'email' => 'example@example.com',
    'password' => Hash::make('password'),
    'first_name' => 'Jane',
    'last_name' => 'Doe',
]);
