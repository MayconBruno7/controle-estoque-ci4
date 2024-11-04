<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Desabilitar verificação de chave estrangeira
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        // Defina a variável @current_user
        $this->db->query("SET @current_user = '0';");

        // Chame os seeders
        $this->call('EstadoSeeder');
        $this->call('CidadeSeeder');
        $this->call('CargoSeeder');
        $this->call('FuncionarioSeeder');
        $this->call('SetorSeeder');
        $this->call('FornecedorSeeder');
        $this->call('ProdutoSeeder');

        // Habilitar novamente a verificação de chave estrangeira
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}
