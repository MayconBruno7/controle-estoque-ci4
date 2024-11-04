<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SetorSeeder extends Seeder
{
    public function run()
    {
        // Limpar a tabela de maneira segura (sem truncar)
        $this->db->table('setor')->where('1 = 1')->delete(); // Remove todos os registros

        // Se o ID for autoincrementado, remova-o do array de dados
        $data = [
            ['nome' => 'Secretária de administração', 'responsavel' => '1', 'statusRegistro' => '1']
        ];

        // Inserir dados na tabela
        $this->db->table('setor')->insertBatch($data);
    }
}
