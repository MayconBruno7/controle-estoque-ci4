<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoFuncionario extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_funcionario AFTER INSERT ON funcionario FOR EACH ROW BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_novos)
                VALUES (
                    'funcionario',
                    'INSERT',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        '{\"id\":', NEW.id, ', ',
                        '\"nome\":\"', NEW.nome, '\", ',
                        '\"cpf\":\"', NEW.cpf, '\", ',
                        '\"telefone\":\"', NEW.telefone, '\", ',
                        '\"setor\":', NEW.setor, ', ',
                        '\"salario\":', NEW.salario, ', ',
                        '\"statusRegistro\":', NEW.statusRegistro, ', ',
                        '\"cargo\":', NEW.cargo, ', ',
                        '\"imagem\":\"', NEW.imagem, '\"}'
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_insert_log_info_funcionario");
    }
}