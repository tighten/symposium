<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\User;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
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
