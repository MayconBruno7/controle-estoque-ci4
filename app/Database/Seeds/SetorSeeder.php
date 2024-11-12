<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SetorSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0'); // Desabilitar verificação de chave estrangeira

        // Se o ID for autoincrementado, remova-o do array de dados
        $data = [
            ['nome' => 'Secretária de administração', 'responsavel' => '1', 'statusRegistro' => '1']
        ];

        // Inserir dados na tabela
        $this->db->table('setor')->insertBatch($data);
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1'); // Desabilitar verificação de chave estrangeira
    }
}
