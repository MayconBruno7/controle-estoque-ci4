<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Fornecedor extends Migration
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
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 144, 
            ],
            'cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => 14,
            ],
            'endereco' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'cidade' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'estado' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'bairro' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'statusRegistro' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 1,
                'comment' => '1 - Ativo    2 - Inativo',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('cidade');
        $this->forge->addKey('estado');
        $this->forge->addForeignKey('cidade', 'cidade', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('estado', 'estado', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('fornecedor', false, ['ENGINE' => 'InnoDB']);

         // Desabilitar verificação de chave estrangeira
         $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->forge->dropTable('fornecedor');
    }
}