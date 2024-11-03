<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgDeleteBloqueiaMovimentacaoFinalSemana extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_delete_bloqueia_movimentacao_final_semana
            BEFORE DELETE ON movimentacao
            FOR EACH ROW 
            BEGIN
                DECLARE dia_semana INT;
                SET dia_semana = DAYOFWEEK(CURDATE());

                IF dia_semana IN (1, 7) THEN
                    SIGNAL SQLSTATE '45000' 
                    SET MESSAGE_TEXT = 'Operações não são permitidas no final de semana';
                END IF;
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_delete_bloqueia_movimentacao_final_semana");
    }
}