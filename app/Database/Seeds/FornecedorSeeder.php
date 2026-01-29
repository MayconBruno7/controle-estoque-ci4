<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FornecedorSeeder extends Seeder
{
    public function run()
    {

       $this->db->query('SET FOREIGN_KEY_CHECKS = 0'); // Desabilitar verificação de chave estrangeira

       $data = [

           ['nome' => 'MD fasdfasdfs', 'cnpj' => '6456456455', 'endereco' => ' Rua Padre Guilherme Goossens, S/N',
           'cidade' => '1983', 'estado' => '13', 'bairro' => 'Sagrado Coracao de Jesus', 'numero' => NULL, 
           'telefone' => '(32) 99919-7525',
           'statusRegistro' => '1'] 
       ];

       $this->db->table('fornecedor')->insertBatch($data);
       $this->db->query('SET FOREIGN_KEY_CHECKS = 1'); // Desabilitar verificação de chave estrangeira
    }
}
