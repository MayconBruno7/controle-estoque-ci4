<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgUpdateLogInfoCargo extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_update_log_info_cargo
            AFTER UPDATE ON cargo
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos, dados_novos)
                VALUES (
                    'cargo',
                    'UPDATE',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        'ID: ', OLD.id,
                        ', Nome: ', COALESCE(OLD.nome, ''),
                        ', Status do Registro: ', OLD.statusRegistro
                    ),
                    CONCAT(
                        'ID: ', NEW.id,
                        ', Nome: ', COALESCE(NEW.nome, ''),
                        ', Status do Registro: ', NEW.statusRegistro
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_update_log_info_cargo");
    }
}