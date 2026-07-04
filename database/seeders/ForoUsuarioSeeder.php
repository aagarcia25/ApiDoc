<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\ForoUsuario;

class ForoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'nombre' => 'Administrador',
                'usuario' => 'admin',
                'password' => 'Admin123*',
                'activo' => true,
            ],
            [
                'nombre' => 'Acceso',
                'usuario' => 'acceso',
                'password' => 'ForoConta26*',
                'activo' => true,
            ],
        ];

        foreach ($usuarios as $usuario) {
            ForoUsuario::updateOrCreate(
                ['usuario' => $usuario['usuario']],
                $usuario
            );
        }
    }
}