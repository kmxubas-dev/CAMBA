<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use Database\Seeders\app\ProductAuctionSeeder;
use Database\Seeders\app\ProductBidSeeder;
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
        $user = User::factory()->create([
            'fname' => 'User',
            'lname' => '1',
            'email' => 'user@email.com',
        ]);

        UserInfo::factory()->for($user)->create();

        User::factory(20)->create();

        $this->call([
            ProductSeeder::class,
            ProductAuctionSeeder::class,
            ProductBidSeeder::class
        ]);
    }
}
