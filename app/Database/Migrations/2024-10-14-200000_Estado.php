<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Estado extends Migration
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
                'constraint' => 50,
            ],
            'sigla' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'regiao' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);


        $this->forge->addKey('id', true);

        $this->forge->createTable('estado', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('estado');
    }
}
