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
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@teste.com',
            'password' => '12345678'
        ]);

        User::create([
            'name' => 'Usuário Teste',
            'email' => 'teste@teste.com',
            'password' => '12345678'
        ]);
    }
}
