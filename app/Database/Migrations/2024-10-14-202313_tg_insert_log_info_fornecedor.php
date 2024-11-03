<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoFornecedor extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_fornecedor AFTER INSERT ON fornecedor FOR EACH ROW BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_novos)
                VALUES (
                    'fornecedor',
                    'INSERT',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        '{\"id\":', NEW.id, ', ',
                        '\"nome\":\"', NEW.nome, '\", ',
                        '\"cnpj\":\"', NEW.cnpj, '\", ',
                        '\"endereco\":\"', NEW.endereco, '\", ',
                        '\"cidade\":', NEW.cidade, ', ',
                        '\"estado\":', NEW.estado, ', ',
                        '\"bairro\":\"', NEW.bairro, '\", ',
                        '\"numero\":\"', NEW.numero, '\", ',
                        '\"telefone\":\"', NEW.telefone, '\", ',
                        '\"statusRegistro\":', NEW.statusRegistro, '}'
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_insert_log_info_fornecedor");
    }
}