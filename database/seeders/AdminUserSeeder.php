<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Decano',
                'email'    => 'decano@fis.edu.pe',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Director de Escuela',
                'email'    => 'director.escuela@fis.edu.pe',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Director de Departamento',
                'email'    => 'director.departamento@fis.edu.pe',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Administrativo',
                'email'    => 'admin@fis.edu.pe',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
