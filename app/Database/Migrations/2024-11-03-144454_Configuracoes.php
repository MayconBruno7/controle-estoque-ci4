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
                'default'    => 'CURRENT_TIMESTAMP',
            ],
            'atualizado_em' => [
                'type'       => 'TIMESTAMP',
                'null'      => true,
                'default'    => 'CURRENT_TIMESTAMP',
                'on_update'  => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('chave');

        $this->forge->createTable('configuracoes', true);
    }

    public function down()
    {
        $this->forge->dropTable('configuracoes');
    }
}
