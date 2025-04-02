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
        return [
            'user_id' => User::factory(),
            'product_id' => 1,
            'purchasable_type' => 'App\Models\Product',
            'purchasable_id' => 1,
            'amount' => fake()->randomFloat(2, 300, 10000),
            'status' => fake()->randomElement(['requested', 'pending', 'paid', 'successful']),
            'purchase_info' => [
                'code' => 'CMB-' . now()->format('Ymd') . '-' . 
                        strtoupper(fake()->unique()->bothify('##??##??')),
                'product_snapshot' => Product::find(1)->toArray(),
            ],
            'payment_info' => [
                'method' => fake()->randomElement(['cod', 'gcash', 'grab_pay']),
                'status' => fake()->randomElement(['pending', 'paid', 'failed']),
                'reference' => 'txn_' . fake()->unique()->regexify('[A-Za-z0-9]{12}'),
                'gateway' => fake()->randomElement(['paymongo', 'stripe', 'paypal']),
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
                        strtoupper(fake()->unique()->bothify('##??##??')),
                'product_snapshot' => $product->toArray(),
            ],
        ]);
    }
}
