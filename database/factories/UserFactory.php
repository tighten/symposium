<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        static $password;

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password ?: $password = Hash::make('password'),
            'remember_token' => Str::random(10),
            'profile_slug' => $this->faker->word,
        ];
    }

    public function wantsNotifications()
    {
        return $this->state(function () {
            return [
                'wants_notifications' => true,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function () {
            return [
                'role' => User::ADMIN_ROLE,
            ];
        });
    }
}
