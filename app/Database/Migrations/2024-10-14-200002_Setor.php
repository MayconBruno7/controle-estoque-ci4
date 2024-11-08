<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Setor extends Migration
{
    public function up()
    {
        // Desabilitar verificação de chave estrangeira
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'responsavel' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,  
                'null' => true,
            ],
            'statusRegistro' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 1,
            ],
        ]);

        $this->forge->addKey('id', true, true);
        $this->forge->addKey('responsavel');
        
        // Adicionando a chave estrangeira para `responsavel` referenciando `funcionario.id`
        $this->forge->addForeignKey('responsavel', 'funcionario', 'id', 'RESTRICT', 'SET NULL');

        $this->forge->createTable('setor', true, ['ENGINE' => 'InnoDB']);

        // Desabilitar verificação de chave estrangeira
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->forge->dropTable('setor');
    }
}
