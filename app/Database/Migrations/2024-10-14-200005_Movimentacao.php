<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Movimentacao extends Migration
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
            'id_setor' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'id_fornecedor' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'statusRegistro' => [
                'type' => 'INT',
                'constraint' => 10,
                'comment' => '1 - Ativo, 2 - Inativo',
            ],
            'tipo' => [
                'type' => 'INT',
                'constraint' => 10,
                'comment' => '1 - Entrada, 2 - Saída',
            ],
            'motivo' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'data_pedido' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'data_chegada' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true, true);
        $this->forge->addKey('id_fornecedor');
        $this->forge->addKey('id_setor');
        $this->forge->addForeignKey('id_fornecedor', 'fornecedor', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_setor', 'setor', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('movimentacao', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('movimentacao');
    }
}