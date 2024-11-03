<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MovimentacaoItem extends Migration
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
            'id_movimentacoes' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'id_produtos' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'quantidade' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
                'default' => null,
            ],
            'valor' => [
                'type' => 'DOUBLE',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey('id_movimentacoes');
        $this->forge->addKey('id_produtos');

        $this->forge->addForeignKey('id_movimentacoes', 'movimentacao', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_produtos', 'produto', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('movimentacao_item', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('movimentacao_item', true);
    }
}
