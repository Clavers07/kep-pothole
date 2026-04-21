<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin123',
            'email' => 'test@example.com',
            'role' => 'admin',
            'status' => 1,
            'password' => 'password123'
        ]);

        User::factory()->create([
            'name' => 'user1',
            'email' => 'user1@example.com',
            'password' => 'pwuser123'
        ]);
    }
}
