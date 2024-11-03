<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuario extends Migration
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
            'nivel' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'statusRegistro' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'primeiroLogin' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
                'default' => 1,
            ],
            'id_funcionario' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true, true);
        $this->forge->addKey('id_funcionario');
        $this->forge->addForeignKey('id_funcionario', 'funcionario', 'id', 'NO ACTION', 'NO ACTION');
        $this->forge->createTable('usuario', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('usuario', true);
    }
}