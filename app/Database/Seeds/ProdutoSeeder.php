<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run()
    {

        // Truncar a tabela
        $this->db->table('produto')->truncate();

        $data = [
            ['descricao' => 'SSD 480GB da marca kingston', 'quantidade' => '0','statusRegistro' => '1',
            'condicao' => '1', 'nome' => 'SSD 480GB', 'fornecedor' => 1] 
        ];

        $this->db->table('produto')->insertBatch($data);
    }
}
