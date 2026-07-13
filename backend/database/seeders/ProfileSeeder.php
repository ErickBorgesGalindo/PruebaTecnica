<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            ['code' => 'PRF-001', 'name' => 'Administrador', 'sections' => ['products', 'users', 'profiles']],
            ['code' => 'PRF-002', 'name' => 'Solo Lectura', 'sections' => ['products']],
            ['code' => 'PRF-003', 'name' => 'Gestor de Usuarios', 'sections' => ['users', 'profiles']],
        ];

        foreach ($profiles as $profile) {
            Profile::create($profile);
        }
    }
}