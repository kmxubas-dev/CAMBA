<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->info()->create([
            'fname' => 'Test',
            'lname' => 'User',
        ]);

        User::factory(20)->create();

        $this->call([
            ProductSeeder::class
        ]);
    }
}
