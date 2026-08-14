<?php

namespace Database\Seeders;

use App\Models\Usuario;
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
        Usuario::create([
            'nombre' => 'Test User',
            'correo' => 'test@example.com',
            'clave' => 'password',//El cast 'hashed' del modelo lo hashea al guardar
        ]);
    }
}
