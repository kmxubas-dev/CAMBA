<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'birthdate' => fake()->date(),
            'address' => fake()->address(),
            'contact' => '+639'.fake()->numerify('#########'),
            'others' => null,
        ];
    }

    /**
     * State - unfilled UserInfo.
     */
    public function unfilled(): static
    {
        return $this->state(fn (array $attributes) => [
            'birthdate' => null,
            'address' => null,
            'contact' => null,
            'others' => null,
        ]);
    }
}
