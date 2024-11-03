<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsuarioRecuperaSenha extends Migration
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
            'usuario_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'chave' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
            ],
            'statusRegistro' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        $this->forge->addKey('usuario_id');
        $this->forge->addForeignKey('usuario_id', 'usuario', 'id', 'NO ACTION', 'NO ACTION');
        
        $this->forge->createTable('usuariorecuperasenha', true, ['ENGINE' => 'InnoDB']);

        $this->db->query("ALTER TABLE usuariorecuperasenha MODIFY created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
    }

    public function down()
    {
        $this->forge->dropTable('usuariorecuperasenha', true);
    }
}
