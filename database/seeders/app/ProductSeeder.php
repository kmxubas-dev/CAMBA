<?php

namespace Database\Seeders\app;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::inRandomOrder()->get();

        foreach ($users as $user) {
            $random_count = rand(3, 13);

            Product::factory()->for($user)->count($random_count)->create();
        }
    }
}
