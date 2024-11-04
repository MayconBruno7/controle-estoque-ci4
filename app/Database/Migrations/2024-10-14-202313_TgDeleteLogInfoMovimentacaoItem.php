<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgDeleteLogInfoMovimentacaoItem extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_delete_log_info_movimentacao_item
            AFTER DELETE ON movimentacao_item
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos)
                VALUES (
                    'movimentacao_item',
                    'DELETE',
                    CURRENT_TIMESTAMP,
                    @current_user, 
                    CONCAT(
                        'id: ', OLD.id, 
                        ', id_movimentacoes: ', OLD.id_movimentacoes, 
                        ', id_produtos: ', OLD.id_produtos, 
                        ', quantidade: ', coalesce(OLD.quantidade, 0), 
                        ', valor: ', coalesce(OLD.valor, 0)
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_delete_log_info_movimentacao_item");
    }
}