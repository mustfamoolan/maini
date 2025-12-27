<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        if (!User::where('phone', '852-8287-8781')->exists()) {
            User::create([
                'name' => 'Admin',
                'phone' => '852-8287-8781',
                'email' => null,
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
