<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgUpdateLogInfoSetor extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_update_log_info_setor AFTER UPDATE ON setor FOR EACH ROW BEGIN
                INSERT INTO logs (tabela, acao, usuario, dados_novos)
                VALUES ('setor', 'UPDATE', @current_user, CONCAT('ID: ', NEW.id, ', Nome: ', NEW.nome, ', Responsável: ', NEW.responsavel, ', Status do Registro: ', NEW.statusRegistro));
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_update_log_info_setor");
    }
}