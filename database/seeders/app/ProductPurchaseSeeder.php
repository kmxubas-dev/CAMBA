<?php

namespace Database\Seeders\app;

use App\Models\Product;
use App\Models\ProductAuction;
use App\Models\ProductPurchase;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::inRandomOrder()->limit(10)->get();
        $auctions = ProductAuction::with('product')->inRandomOrder()->limit(10)->get();
        $products = Product::doesntHave('auction')->inRandomOrder()->limit(10)->get();

        foreach ($users as $user) {
            foreach ($auctions as $auction) {
                ProductPurchase::factory()
                    ->for($user, 'user')
                    ->forPurchasable($auction, $auction->product)
                    ->create();
            }

            foreach ($products as $product) {
                ProductPurchase::factory()
                    ->for($user, 'user')
                    ->forPurchasable($product, $product)
                    ->create();
            }
        }
    }
}
