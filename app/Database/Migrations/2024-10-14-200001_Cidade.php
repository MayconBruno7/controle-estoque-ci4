<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cidade extends Migration
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
                'constraint' => 150,
            ],
            'codigo_municipio' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'estado' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('estado', 'estado', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('cidade', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropForeignKey('cidade', 'cidade_estado_foreign');
        
        $this->forge->dropTable('cidade');
    }
}
