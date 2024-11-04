<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CargoSeeder extends Seeder
{
    public function run()
    {
        
        // Truncar a tabela
        $this->db->table('cargo')->truncate();

        $data = [
            ['id' => '1', 'nome' => 'Secretário(a) de Administração', 'statusRegistro' => '1']
        ];

        $this->db->table('cargo')->insertBatch($data);
    }
}
