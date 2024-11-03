<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'nome' => 'Acre', 'sigla' => 'AC', 'regiao' => 'Norte'],
            ['id' => 2, 'nome' => 'Alagoas', 'sigla' => 'AL', 'regiao' => 'Nordeste'],
            ['id' => 3, 'nome' => 'Amapá', 'sigla' => 'AP', 'regiao' => 'Norte'],
            ['id' => 4, 'nome' => 'Amazonas', 'sigla' => 'AM', 'regiao' => 'Norte'],
            ['id' => 5, 'nome' => 'Bahia', 'sigla' => 'BA', 'regiao' => 'Nordeste'],
            ['id' => 6, 'nome' => 'Ceará', 'sigla' => 'CE', 'regiao' => 'Nordeste'],
            ['id' => 7, 'nome' => 'Distrito Federal', 'sigla' => 'DF', 'regiao' => 'Centro-Oeste'],
            ['id' => 8, 'nome' => 'Espírito Santo', 'sigla' => 'ES', 'regiao' => 'Sudeste'],
            ['id' => 9, 'nome' => 'Goiás', 'sigla' => 'GO', 'regiao' => 'Centro-Oeste'],
            ['id' => 10, 'nome' => 'Maranhão', 'sigla' => 'MA', 'regiao' => 'Nordeste'],
            ['id' => 11, 'nome' => 'Mato Grosso', 'sigla' => 'MT', 'regiao' => 'Centro-Oeste'],
            ['id' => 12, 'nome' => 'Mato Grosso do Sul', 'sigla' => 'MS', 'regiao' => 'Centro-Oeste'],
            ['id' => 13, 'nome' => 'Minas Gerais', 'sigla' => 'MG', 'regiao' => 'Sudeste'],
            ['id' => 14, 'nome' => 'Pará', 'sigla' => 'PA', 'regiao' => 'Norte'],
            ['id' => 15, 'nome' => 'Paraíba', 'sigla' => 'PB', 'regiao' => 'Nordeste'],
            ['id' => 16, 'nome' => 'Paraná', 'sigla' => 'PR', 'regiao' => 'Sul'],
            ['id' => 17, 'nome' => 'Pernambuco', 'sigla' => 'PE', 'regiao' => 'Nordeste'],
            ['id' => 18, 'nome' => 'Piauí', 'sigla' => 'PI', 'regiao' => 'Nordeste'],
            ['id' => 19, 'nome' => 'Rio de Janeiro', 'sigla' => 'RJ', 'regiao' => 'Sudeste'],
            ['id' => 20, 'nome' => 'Rio Grande do Norte', 'sigla' => 'RN', 'regiao' => 'Nordeste'],
            ['id' => 21, 'nome' => 'Rio Grande do Sul', 'sigla' => 'RS', 'regiao' => 'Sul'],
            ['id' => 22, 'nome' => 'Rondônia', 'sigla' => 'RO', 'regiao' => 'Norte'],
            ['id' => 23, 'nome' => 'Roraima', 'sigla' => 'RR', 'regiao' => 'Norte'],
            ['id' => 24, 'nome' => 'Santa Catarina', 'sigla' => 'SC', 'regiao' => 'Sul'],
            ['id' => 25, 'nome' => 'São Paulo', 'sigla' => 'SP', 'regiao' => 'Sudeste'],
            ['id' => 26, 'nome' => 'Sergipe', 'sigla' => 'SE', 'regiao' => 'Nordeste'],
            ['id' => 27, 'nome' => 'Tocantins', 'sigla' => 'TO', 'regiao' => 'Norte'],
        ];

        $this->db->table('estado')->insertBatch($data);
    }
}

