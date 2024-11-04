<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgUpdateLogInfoFuncionario extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_update_log_info_funcionario
            AFTER UPDATE ON funcionario
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos, dados_novos)
                VALUES (
                    'funcionario',
                    'UPDATE',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        'ID: ', OLD.id,
                        ', Nome: ', OLD.nome,
                        ', CPF: ', OLD.cpf,
                        ', Telefone: ', COALESCE(OLD.telefone, ''),
                        ', Setor: ', COALESCE(OLD.setor, 0),
                        ', Salário: ', COALESCE(OLD.salario, 0),
                        ', Status do Registro: ', OLD.statusRegistro,
                        ', Cargo: ', COALESCE(OLD.cargo, 0),
                        ', Imagem: ', COALESCE(OLD.imagem, '')
                    ),
                    CONCAT(
                        'ID: ', NEW.id,
                        ', Nome: ', NEW.nome,
                        ', CPF: ', NEW.cpf,
                        ', Telefone: ', COALESCE(NEW.telefone, ''),
                        ', Setor: ', COALESCE(NEW.setor, 0),
                        ', Salário: ', COALESCE(NEW.salario, 0),
                        ', Status do Registro: ', NEW.statusRegistro,
                        ', Cargo: ', COALESCE(NEW.cargo, 0),
                        ', Imagem: ', COALESCE(NEW.imagem, '')
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_update_log_info_funcionario");
    }
}