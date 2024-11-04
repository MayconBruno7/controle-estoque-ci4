<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    public function run()
    {
        // Truncar a tabela
        $this->db->table('funcionario')->truncate();

        $data = [
            ['id' => '1', 'nome' => 'João', 'cpf' => '09078945618', 'telefone' => '32984952615',
            'setor' => '1', 'salario' => '1420', 'statusRegistro' => '1', 'cargo' => 1] 
        ];

        $this->db->table('funcionario')->insertBatch($data);
    }
}
