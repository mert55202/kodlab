<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ContentSeeder::class);

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@kodlab.com',
            'password' => bcrypt('admin123'),
            'is_premium' => true,
            'total_points' => 0,
        ]);

        User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@kodlab.com',
            'password' => bcrypt('test123'),
            'is_premium' => false,
            'total_points' => 0,
        ]);
    }
}
