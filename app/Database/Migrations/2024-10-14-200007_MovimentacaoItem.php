<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MovimentacaoItem extends Migration
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

        $this->forge->addForeignKey('id_movimentacoes', 'movimentacao', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('id_produtos', 'produto', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('movimentacao_item', true, ['ENGINE' => 'InnoDB']);

         // Desabilitar verificação de chave estrangeira
         $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->forge->dropTable('movimentacao_item', true);
    }
}
