<?php

namespace Database\Seeders;

use App\Models\User;
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
    }
}
