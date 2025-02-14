<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Automatically associate with a user
            'name' => fake()->word,
            'qty' => fake()->numberBetween(1, 10),
            'price' => fake()->randomFloat(2, 300, 10000),
            'images' => 'assets/img/placeholder_product.png',
            'description' => fake()->sentence(10),
            'attributes' => [
                'size' => fake()->numberBetween(10, 50).'x'.fake()->numberBetween(10, 50).'cm',
                'type' => fake()->randomElement([
                    'Oil Painting',
                    'Acrylic Painting',
                    'Watercolor',
                    'Pastel Painting',
                    'Digital Painting',
                    'Charcoal Drawing',
                    'Ink Wash',
                    'Spray Paint'
                ]),
                'year' => fake()->year,
            ],
        ];
    }
}
