<?php

namespace Database\Seeders\app;

use App\Models\Product;
use App\Models\ProductAuction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products_count = Product::count();

        $products_limit = rand($products_count/2, $products_count);

        $products = Product::inRandomOrder()->limit($products_limit)->get();

        $product_auctions = ProductAuction::pluck('product_id')->toArray();

        foreach ($products as $product) {
            if (!in_array($product->id, $product_auctions)) {
                ProductAuction::factory()->for($product)->create();
            }
        }
    }
}
