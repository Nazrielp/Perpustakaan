<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'username' => 'admin_24',
            'password' => 'admin_24',
            'role' => 'admin'
        ]);

        User::create([
            'username' => 'user_24',
            'password' => 'user_24',
        ]);
    }
}
