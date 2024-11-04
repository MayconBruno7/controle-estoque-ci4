<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoSetor extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_setor
            AFTER INSERT ON setor
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, usuario, dados_novos)
                VALUES (
                    'setor',
                    'INSERT',
                    @current_user,
                    CONCAT(
                        'ID: ', NEW.id,
                        ', Nome: ', NEW.nome,
                        ', Responsável: ', COALESCE(NEW.responsavel, 0),
                        ', Status do Registro: ', NEW.statusRegistro
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_insert_log_info_setor");
    }
}