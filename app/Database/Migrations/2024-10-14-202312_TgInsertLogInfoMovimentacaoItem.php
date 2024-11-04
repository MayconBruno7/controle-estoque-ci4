<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoMovimentacaoItem extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_movimentacao_item
            AFTER INSERT ON movimentacao_item
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_novos)
                VALUES (
                    'movimentacao_item',
                    'INSERT',
                    CURRENT_TIMESTAMP,
                    @current_user, 
                    CONCAT(
                        'id: ', NEW.id,
                        ', id_movimentacoes: ', NEW.id_movimentacoes,
                        ', id_produtos: ', NEW.id_produtos,
                        ', quantidade: ', COALESCE(NEW.quantidade, 0),
                        ', valor: ', COALESCE(NEW.valor, 0)
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_insert_log_info_movimentacao_item");
    }
}