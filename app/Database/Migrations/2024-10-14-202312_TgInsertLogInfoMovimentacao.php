<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoMovimentacao extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_movimentacao
            AFTER INSERT ON movimentacao
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_novos)
                VALUES (
                    'movimentacao',
                    'INSERT',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        'id: ', NEW.id,
                        ', id_setor: ', NEW.id_setor,
                        ', id_fornecedor: ', NEW.id_fornecedor,
                        ', statusRegistro: ', NEW.statusRegistro,
                        ', tipo: ', NEW.tipo,
                        ', motivo: ', COALESCE(NEW.motivo, ''),
                        ', data_pedido: ', COALESCE(NEW.data_pedido, ''),
                        ', data_chegada: ', COALESCE(NEW.data_chegada, '')
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_insert_log_info_movimentacao");
    }
}