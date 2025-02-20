<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAuction>
 */
class ProductAuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'status' => $this->faker->randomElement([
                'inactive',
                'active',
                'completed',
                'cancelled',
                'sold'
            ]),
            'price' => $this->faker->randomFloat(4, 1000, 10000),
            'start' => $this->faker->dateTimeBetween('-12 hours', 'now'),
            'end' => $this->faker->dateTimeBetween('now', '+2 days'),
        ];
    }
}
