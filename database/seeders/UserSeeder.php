<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin4070@gmail.com',
            'password' => 'Cristiano.ronaldo7@',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Julie',
            'email' => 'julie.livreur@outlook.fr',
            'password' => 'France2023@',
            'role' => 'livreur',
        ]);
    }
}