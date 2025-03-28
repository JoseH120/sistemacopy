<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Usuario extends Seeder
{
    public function run()
    {
        //
        $data = [
            'usuario' => 'Jose Hernandez',
            'clave' => password_hash('password', PASSWORD_DEFAULT),
            'email' => 'jose@gmail.com',
            'Tipo' => 'ADMINISTRADOR',
            'activo' => 1,
        ];
        // Preparando consulta de sql
        $this->db->query(
            <<<text
            INSERT INTO usuarios (usuario, clave, email, tipo, activo) values(:usuario:, :clave:, :email:, :tipo:, :activo:)
            text,
            $data
        );
    }
}
