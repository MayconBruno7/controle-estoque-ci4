<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgBeforeDeleteMovimentacao extends Migration
{
    public function up()
    {
        $this->db->query("


            CREATE TRIGGER tg_before_delete_movimentacao
            BEFORE DELETE ON movimentacao
            FOR EACH ROW
            BEGIN
                DECLARE v_tipo INT;
                DECLARE v_estoque_atual INT;

                SET v_tipo = OLD.tipo;

                IF v_tipo IN (1, 2) THEN
                    SELECT SUM(mi.quantidade) INTO v_estoque_atual
                    FROM movimentacao_item mi
                    WHERE mi.id_movimentacoes = OLD.id;
                END IF;

                UPDATE produto p
                JOIN movimentacao_item mi ON p.id = mi.id_produtos
                SET p.quantidade = CASE
                    WHEN v_tipo = 1 THEN p.quantidade - mi.quantidade
                    WHEN v_tipo = 2 THEN p.quantidade + mi.quantidade
                END
                WHERE mi.id_movimentacoes = OLD.id;

            END; 

         
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_before_delete_movimentacao");
    }
}