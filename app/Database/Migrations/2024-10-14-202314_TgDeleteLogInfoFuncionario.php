<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgDeleteLogInfoFuncionario extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_delete_log_info_funcionario
            AFTER DELETE ON funcionario
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos)
                VALUES (
                    'funcionario',
                    'DELETE',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        'id: ', OLD.id,
                        ', nome: ', OLD.nome,
                        ', cpf: ', OLD.cpf,
                        ', telefone: ', OLD.telefone,
                        ', setor: ', COALESCE(OLD.setor, '0'),
                        ', salario: ', COALESCE(OLD.salario, '0'),
                        ', statusRegistro: ', OLD.statusRegistro,
                        ', cargo: ', COALESCE(OLD.cargo, '0'),
                        ', imagem: ', COALESCE(OLD.imagem, ' ')
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_delete_log_info_funcionario");
    }
}