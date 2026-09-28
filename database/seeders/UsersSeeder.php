<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'João Operador',
            'email' => 'operador@empresa.com',
            'role' => 'operador',
            'password' => Hash::make('senha123'),
        ]);

        User::factory()->create([
            'name' => 'Maria Gerente',
            'email' => 'gerente@empresa.com',
            'role' => 'gerente',
            'password' => Hash::make('senha123'),
        ]);

        User::factory()->create([
            'name' => 'Carlos Admin',
            'email' => 'admin@empresa.com',
            'role' => 'admin',
            'password' => Hash::make('senha123'),
        ]);
    }
}