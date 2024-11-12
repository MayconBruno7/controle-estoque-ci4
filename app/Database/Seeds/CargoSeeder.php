<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CargoSeeder extends Seeder
{
    public function run()
    {
        
        // Desabilitar verificação de chave estrangeira
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0'); // Desabilitar verificação de chave estrangeira

        $data = [
            ['id' => '1', 'nome' => 'Secretário(a) de Administração', 'statusRegistro' => '1']
        ];

        $this->db->table('cargo')->insertBatch($data);

        $this->db->query('SET FOREIGN_KEY_CHECKS = 1'); // Desabilitar verificação de chave estrangeira
    }
}
