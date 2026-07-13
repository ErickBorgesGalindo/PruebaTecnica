<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['code' => 'USR-001', 'name' => 'Admin', 'email' => 'admin@test.com', 'phone' => '+521234567890', 'photo_url' => 'https://example.com/admin.jpg', 'password' => Hash::make('password123')],
            ['code' => 'USR-002', 'name' => 'María López', 'email' => 'maria@test.com', 'phone' => '+520987654321', 'photo_url' => 'https://example.com/maria.jpg', 'password' => Hash::make('password123')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}