<?php

namespace Database\Seeders\app;

use App\Models\ProductAuction;
use App\Models\ProductBid;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_count = User::count();
        $users_limit = rand($users_count/2, $users_count);
        $users = User::inRandomOrder()->limit($users_limit)->get();

        $auctions_count = ProductAuction::count();
        $auctions_limit = rand($auctions_count/2, $auctions_count);
        $auctions = ProductAuction::with('product')
                        ->inRandomOrder()
                        ->limit($auctions_limit)
                        ->get();

        foreach ($users as $user) {
            foreach ($auctions as $auction) {
                if ($auction->product->user_id == $user->id) {
                    continue;
                }

                $bid_exists = ProductBid::where('user_id', $user->id)
                                    ->where('auction_id', $auction->id)
                                    ->exists();

                if (!$bid_exists) {
                    ProductBid::factory()->for($user, 'user')->for($auction, 'auction')->create();
                }
            }
        }
    }
}
