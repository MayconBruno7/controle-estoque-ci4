<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Funcionario extends Migration
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
                'constraint' => 80,
                'default' => '0',
            ],
            'cpf' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'default' => '0',
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'setor' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
                'default' => 0,
            ],
            'salario' => [
                'type' => 'DECIMAL',
                'constraint' => '20,6',
            ],
            'statusRegistro' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 1,
                'comment' => '1 - Ativo    2 - Inativo',
            ],
            'cargo' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'imagem' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true, true);
        $this->forge->addKey('setor');
        $this->forge->addKey('cargo');
        $this->forge->addForeignKey('cargo', 'cargo', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('setor', 'setor', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('funcionario', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('funcionario');
    }
}