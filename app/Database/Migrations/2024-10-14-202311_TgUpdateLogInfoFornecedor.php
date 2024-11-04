<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgUpdateLogInfoFornecedor extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_update_log_info_fornecedor
            AFTER UPDATE ON fornecedor
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos, dados_novos)
                VALUES (
                    'fornecedor',
                    'UPDATE',
                    CURRENT_TIMESTAMP,
                    @current_user,
                    CONCAT(
                        'ID: ', OLD.id,
                        ', Nome: ', OLD.nome,
                        ', CNPJ: ', OLD.cnpj,
                        ', Endereço: ', COALESCE(OLD.endereco, ''),
                        ', Cidade: ', COALESCE(OLD.cidade, 0),
                        ', Estado: ', COALESCE(OLD.estado, 0),
                        ', Bairro: ', COALESCE(OLD.bairro, ''),
                        ', Número: ', COALESCE(OLD.numero, 0),
                        ', Telefone: ', COALESCE(OLD.telefone, ''),
                        ', Status do Registro: ', OLD.statusRegistro
                    ),
                    CONCAT(
                        'ID: ', NEW.id,
                        ', Nome: ', NEW.nome,
                        ', CNPJ: ', NEW.cnpj,
                        ', Endereço: ', COALESCE(NEW.endereco, ''),
                        ', Cidade: ', COALESCE(NEW.cidade, 0),
                        ', Estado: ', COALESCE(NEW.estado, 0),
                        ', Bairro: ', COALESCE(NEW.bairro, ''),
                        ', Número: ', COALESCE(NEW.numero, 0),
                        ', Telefone: ', COALESCE(NEW.telefone, ''),
                        ', Status do Registro: ', NEW.statusRegistro
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