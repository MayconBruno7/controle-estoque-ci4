<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoCargo extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_cargo AFTER INSERT ON cargo FOR EACH ROW BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_novos)
                VALUES (
                    'cargo',
                    'INSERT',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT('{\"id\":', NEW.id, ', \"nome\":\"', NEW.nome, '\", \"statusRegistro\":', NEW.statusRegistro, '}')
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_insert_log_info_cargo");
    }
}