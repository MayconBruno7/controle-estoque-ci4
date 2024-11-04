<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgUpdateLogInfoMovimentacao extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_update_log_info_movimentacao
            AFTER UPDATE ON movimentacao
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos, dados_novos)
                VALUES (
                    'movimentacao',
                    'UPDATE',
                    CURRENT_TIMESTAMP,
                    @current_user, 
                    CONCAT(
                        'ID: ', OLD.id,
                        'ID Setor: ', COALESCE(OLD.id_setor, 0),
                        'ID Fornecedor: ', COALESCE(OLD.id_fornecedor, 0),
                        'Status do Registro: ', OLD.statusRegistro,
                        'Tipo: ', COALESCE(OLD.tipo, 0),
                        'Motivo: ', COALESCE(OLD.motivo, ''),
                        'Data do Pedido: ', COALESCE(OLD.data_pedido, ''),
                        'Data de Chegada: ', COALESCE(OLD.data_chegada, '')
                    ),
                    CONCAT(
                        'ID: ', NEW.id,
                        'ID Setor: ', COALESCE(NEW.id_setor, 0),
                        'ID Fornecedor: ', COALESCE(NEW.id_fornecedor, 0),
                        'Status do Registro: ', NEW.statusRegistro,
                        'Tipo: ', COALESCE(NEW.tipo, 0),
                        'Motivo: ', COALESCE(NEW.motivo, ''),
                        'Data do Pedido: ', COALESCE(NEW.data_pedido, ''),
                        'Data de Chegada: ', COALESCE(NEW.data_chegada, '')
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_update_log_info_movimentacao");
    }
}
