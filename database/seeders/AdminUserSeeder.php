<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin555@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('p3a2ss1word5544'),
            ]
        );
    }
}
