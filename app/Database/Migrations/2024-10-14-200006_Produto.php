<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produto extends Migration
{
    public function up()
    {
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
                'default' => null,
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
            ],
        ]);

        $this->forge->addKey('id', true, true);
        $this->forge->addKey('fornecedor');
        $this->forge->addForeignKey('fornecedor', 'fornecedor', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produto', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('produto');
    }
}