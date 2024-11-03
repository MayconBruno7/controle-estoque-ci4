<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Chame os seeders
        $this->call('EstadoSeeder');
        $this->call('CidadeSeeder');
        // Adicione outros seeders aqui se necessário
    }
}
