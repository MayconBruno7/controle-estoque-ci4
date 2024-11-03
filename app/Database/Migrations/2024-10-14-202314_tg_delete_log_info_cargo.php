<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgDeleteLogInfoCargo extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_delete_log_info_cargo
            AFTER DELETE ON cargo
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos)
                VALUES (
                    'cargo',
                    'DELETE',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT('{\"id\":', OLD.id, ', \"nome\":\"', OLD.nome, '\", \"statusRegistro\":', OLD.statusRegistro, '}')
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_delete_log_info_cargo");
    }
}