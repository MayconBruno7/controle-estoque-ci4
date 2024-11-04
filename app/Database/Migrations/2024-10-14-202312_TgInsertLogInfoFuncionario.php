<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoFuncionario extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_funcionario
            AFTER INSERT ON funcionario
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_novos)
                VALUES (
                    'funcionario',
                    'INSERT',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        'id: ', NEW.id, ', ',
                        'nome: ', NEW.nome, ', ',
                        'cpf: ', NEW.cpf, ', ',
                        'telefone: ', coalesce(NEW.telefone, ''), ', ',
                        'setor: ', coalesce(NEW.setor, 0), ', ',
                        'salario: ', coalesce(NEW.salario, 0), ', ',
                        'statusRegistro: ', NEW.statusRegistro, ', ',
                        'cargo: ', coalesce(NEW.cargo, 0), ', ',
                        'imagem: ', coalesce(NEW.imagem, '')
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