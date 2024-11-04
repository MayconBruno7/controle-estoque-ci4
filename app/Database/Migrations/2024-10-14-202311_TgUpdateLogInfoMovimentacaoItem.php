<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgUpdateLogInfoMovimentacaoItem extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_update_log_info_movimentacao_item
            AFTER UPDATE ON movimentacao_item
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos, dados_novos)
                VALUES (
                    'movimentacao_item',
                    'UPDATE',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        'ID: ', OLD.id,
                        ', ID Movimentação: ', OLD.id_movimentacoes,
                        ', ID Produto: ', OLD.id_produtos,
                        ', Quantidade: ', COALESCE(OLD.quantidade, 0),
                        ', Valor: ', COALESCE(OLD.valor, 0)
                    ),
                    CONCAT(
                        'ID: ', NEW.id,
                        ', ID Movimentação: ', NEW.id_movimentacoes,
                        ', ID Produto: ', NEW.id_produtos,
                        ', Quantidade: ', COALESCE(NEW.quantidade, 0),
                        ', Valor: ', COALESCE(NEW.valor, 0)
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_update_log_info_movimentacao_item");
    }
}
