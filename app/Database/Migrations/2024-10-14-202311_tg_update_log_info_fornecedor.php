<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgUpdateLogInfoFornecedor extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_update_log_info_fornecedor AFTER UPDATE ON fornecedor FOR EACH ROW BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos, dados_novos)
                VALUES (
                    'fornecedor',
                    'UPDATE',
                    CURRENT_TIMESTAMP,
                    @current_user, -- Substitua com a lógica para obter o usuário atual
                    CONCAT(
                        '{\"id\":', OLD.id, ', ',
                        '\"nome\":\"', OLD.nome, '\", ',
                        '\"cnpj\":\"', OLD.cnpj, '\", ',
                        '\"endereco\":\"', OLD.endereco, '\", ',
                        '\"cidade\":', OLD.cidade, ', ',
                        '\"estado\":', OLD.estado, ', ',
                        '\"bairro\":\"', OLD.bairro, '\", ',
                        '\"numero\":\"', OLD.numero, '\", ',
                        '\"telefone\":\"', OLD.telefone, '\", ',
                        '\"statusRegistro\":', OLD.statusRegistro, '}'
                    ),
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
        $this->db->query("DROP TRIGGER IF EXISTS tg_update_log_info_fornecedor");
    }
}