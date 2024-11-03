<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HistoricoProduto extends Migration
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
            'id_produtos' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'fornecedor_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'nome_produtos' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'descricao_anterior' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'quantidade_anterior' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'status_anterior' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'statusItem_anterior' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'dataMod' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true, true);
        $this->forge->addKey('id_produtos');
        $this->forge->addKey('fornecedor_id');
        $this->forge->addForeignKey('id_produtos', 'produto', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('historico_produto', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('historico_produto');
    }
}