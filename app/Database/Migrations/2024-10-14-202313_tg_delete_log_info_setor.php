<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgDeleteLogInfoSetor extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_delete_log_info_setor
            AFTER DELETE ON setor
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, usuario, dados_novos)
                VALUES (
                    'setor',
                    'DELETE',
                    @current_user, -- Substitua com a lógica para obter o usuário atual
                    CONCAT(
                        'ID: ', OLD.id, ', ',
                        'Nome: ', OLD.nome, ', ',
                        'Responsável: ', OLD.responsavel, ', ',
                        'Status do Registro: ', OLD.statusRegistro
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_delete_log_info_setor");
    }
}