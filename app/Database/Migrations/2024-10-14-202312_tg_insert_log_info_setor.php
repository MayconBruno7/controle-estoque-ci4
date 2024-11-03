<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoSetor extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_setor AFTER INSERT ON setor FOR EACH ROW BEGIN
                INSERT INTO logs (tabela, acao, usuario, dados_novos)
                VALUES (
                    'setor',
                    'INSERT',
                    @current_user, -- Substitua com a lógica para obter o usuário atual
                    CONCAT('ID: ', NEW.id, ', Nome: ', NEW.nome, ', Responsável: ', NEW.responsavel, ', Status do Registro: ', NEW.statusRegistro)
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_insert_log_info_setor");
    }
}