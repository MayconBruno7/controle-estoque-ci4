<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Setor extends Migration
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
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'responsavel' => [
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
        ]);

        $this->forge->addKey('id', true, true);
        $this->forge->addKey('responsavel');
        $this->forge->createTable('setor', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('setor');
    }
}