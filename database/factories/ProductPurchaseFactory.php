<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductAuction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPurchase>
 */
class ProductPurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $purchasable = $this->faker
            ->randomElement([Product::class, ProductAuction::class])::factory()
            ->create();

        $product = $purchasable instanceof ProductAuction
            ? $purchasable->product
            : $purchasable;

        return [
            'user_id' => User::factory(),
            'product_id' => $product->id,
            'purchasable_type' => get_class($purchasable),
            'purchasable_id' => $purchasable->id,
            'amount' => $product->price,
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'purchase_info' => [
                'code' => 'CMB-' . now()->format('Ymd') . '-' . 
                        strtoupper($this->faker->unique()->bothify('##??##??')),
                'product_snapshot' => $product->toArray(),
            ],
            'payment_info' => [
                'method' => $this->faker->randomElement(['paymongo', 'stripe', 'paypal']),
                'status' => $this->faker->randomElement(['pending', 'successful', 'failed']),
                'reference' => 'txn_' . $this->faker->unique()->regexify('[A-Za-z0-9]{12}'),
            ],
        ];
    }

    /**
     * State - Set Purchasable infos
     */
    public function forPurchasable($purchasable, Product $product): static
    {
        return $this->state(fn (array $attributes) => [
            'product_id' => $product->id,
            'purchasable_type' => get_class($purchasable),
            'purchasable_id' => $purchasable->id,
            'amount' => $product->price,
            'purchase_info' => [
                'code' => 'CMB-' . now()->format('Ymd') . '-' .
                        strtoupper($this->faker->unique()->bothify('##??##??')),
                'product_snapshot' => $product->toArray(),
            ],
        ]);
    }
}
