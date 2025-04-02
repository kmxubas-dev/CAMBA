<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAuction;
use App\Models\ProductPurchase;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\app\ProductAuctionSeeder;
use Database\Seeders\app\ProductBidSeeder;
use Database\Seeders\app\ProductPurchaseSeeder;
use Database\Seeders\app\ProductSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'fname' => 'User',
            'lname' => '1',
            'email' => 'user@email.com',
        ]);

        User::factory(10)->create();
        User::factory(10)->unverified()->create();

        $this->call([
            ProductSeeder::class,
            ProductAuctionSeeder::class,
            ProductBidSeeder::class,
            ProductPurchaseSeeder::class
        ]);

        User::factory()->create([
            'type'  => 'admin',
            'fname' => 'Admin',
            'lname' => '1',
            'email' => 'admin@email.com',
        ]);


        // --------------------------------------------------
        // Populate User1 products, auctions, and sales 

        $user1 = User::find(1);
        $products = Product::factory()->for($user1)->count(50)->create();
        foreach ($products as $product) {
            if (random_int(0, 1)) {
                ProductAuction::factory()->for($product)->create();
            }
        }

        // Select 10 random users excluding user1
        $users = User::where('id', '!=', $user1->id)->inRandomOrder()->limit(10)->get();

        // Select 20 of user1's auctions
        $auctions = ProductAuction::whereHas('product', function ($query) use ($user1) {
            $query->where('user_id', $user1->id);
        })->inRandomOrder()->limit(20)->get();

        // Select 20 of user1's non-auction products
        $products = Product::where('user_id', $user1->id)
            ->doesntHave('auction')
            ->inRandomOrder()
            ->limit(20)
            ->get();

        foreach ($auctions as $auction) {
            $randomUser = $users->random();

            ProductPurchase::factory()
                ->for($randomUser, 'user')
                ->forPurchasable($auction, $auction->product)
                ->state([
                    'created_at' => Carbon::createFromTimestamp(
                        rand(Carbon::now()->startOfYear()->timestamp, Carbon::now()->timestamp)
                    ),
                ])
                ->create();
        }

        foreach ($products as $product) {
            $randomUser = $users->random();

            ProductPurchase::factory()
                ->for($randomUser, 'user')
                ->forPurchasable($product, $product)
                ->state([
                    'created_at' => Carbon::createFromTimestamp(
                        rand(Carbon::now()->startOfYear()->timestamp, Carbon::now()->timestamp)
                    ),
                ])
                ->create();
        }

        // --------------------------------------------------
    }
}
