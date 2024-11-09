<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Movimentacao extends Migration
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
            'id_setor' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => null,
            ],
            'id_fornecedor' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => null,
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
        $this->forge->addForeignKey('id_fornecedor', 'fornecedor', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('id_setor', 'setor', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('movimentacao', true, ['ENGINE' => 'InnoDB']);

         // Desabilitar verificação de chave estrangeira
         $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->forge->dropTable('movimentacao');
    }
}