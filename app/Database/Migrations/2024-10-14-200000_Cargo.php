<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cargo extends Migration
{
    public function up()
    {
        // Desabilitar verificação de chave estrangeira
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0'); // Desabilitar verificação de chave estrangeira

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'statusRegistro' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
                'default' => '1',
                'comment' => '1 - Ativo    2 - Inativo',
            ],
        ]);

        $this->forge->addKey('id');

        $this->forge->createTable('cargo', true, ['ENGINE' => 'InnoDB']);

         // Desabilitar verificação de chave estrangeira
         $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->forge->dropTable('cargo');
    }
}
