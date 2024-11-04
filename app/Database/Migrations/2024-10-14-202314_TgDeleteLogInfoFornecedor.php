<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgDeleteLogInfoFornecedor extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_delete_log_info_fornecedor
            AFTER DELETE ON fornecedor
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos)
                VALUES (
                    'fornecedor',
                    'DELETE',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        'id: ', OLD.id,
                        ', nome: ', OLD.nome,
                        ', cnpj: ', OLD.cnpj,
                        ', endereco: ', COALESCE(OLD.endereco, ' '),
                        ', cidade: ', COALESCE(OLD.cidade, '0'),
                        ', estado: ', COALESCE(OLD.estado, '0'),
                        ', bairro: ', COALESCE(OLD.bairro, ' '),
                        ', numero: ', COALESCE(OLD.numero, ' '),
                        ', telefone: ', OLD.telefone,
                        ', statusRegistro: ', OLD.statusRegistro
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_delete_log_info_fornecedor");
    }
}