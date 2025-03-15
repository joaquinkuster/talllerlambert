<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un administrador con datos fijos
        User::create([
            'nombre' => 'Admin',
            'apellido' => 'Admin',
            'dni' => '12345678',
            'telefono' => '123456789',
            'correo' => 'admin@example.com',
            'password' => Hash::make('12345a'), // Contraseña 12345a
            'rol' => 'Administrador', // Asignar el rol de Administrador
        ]);
    }
}
