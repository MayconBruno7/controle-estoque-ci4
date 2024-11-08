<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produto extends Migration
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
            'descricao' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'quantidade' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
                'default' => 0,
            ],
            'statusRegistro' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 1,
            ],
            'condicao' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 1,
            ],
            'dataMod' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'fornecedor' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true, true);
        $this->forge->addKey('fornecedor');
        $this->forge->addForeignKey('fornecedor', 'fornecedor', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('produto', true, ['ENGINE' => 'InnoDB']);

         // Desabilitar verificação de chave estrangeira
         $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->forge->dropTable('produto');
    }
}