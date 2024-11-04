<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfiguracoesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'chave'         => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'      => false,
            ],
            'valor'         => [
                'type'       => 'TEXT',
                'null'      => false,
            ],
            'descricao'     => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'      => true,
            ],
            'criado_em'     => [
                'type'       => 'TIMESTAMP',
                'null'      => true,
            ],
            'atualizado_em' => [
                'type'       => 'TIMESTAMP',
                'null'      => true,
                'on_update'  => 'CURRENT_TIMESTAMP',
            ],
        ]);
    
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('chave');
    
        $this->forge->createTable('configuracoes', true, [
            'ENGINE' => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_0900_ai_ci'
        ]);

        $this->db->query("ALTER TABLE configuracoes MODIFY criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE configuracoes MODIFY atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
    }
    
    public function down()
    {
        $this->forge->dropTable('configuracoes');
    }
}
