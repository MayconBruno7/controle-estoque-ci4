<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgBeforeUpdateMovimentacao extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_before_update_movimentacao
            BEFORE UPDATE ON movimentacao
            FOR EACH ROW
            BEGIN
                DECLARE v_tipo INT;

                IF OLD.tipo != NEW.tipo THEN
                    SET v_tipo = OLD.tipo;

                    UPDATE produto p
                    JOIN movimentacao_item mi ON p.id = mi.id_produtos
                    SET p.quantidade = CASE
                        WHEN v_tipo = 1 THEN p.quantidade - mi.quantidade -- Entrada: subtrai a quantidade
                        WHEN v_tipo = 2 THEN p.quantidade + mi.quantidade -- Saída: adiciona a quantidade
                    END
                    WHERE mi.id_movimentacoes = OLD.id;
                END IF;
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_before_update_movimentacao");
    }
}