<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgAfterUpdateProduto extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_after_update_produto
            AFTER UPDATE ON produto
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, usuario, dados_antigos, dados_novos)
                VALUES (
                    'produto', 
                    'UPDATE', 
                    @current_user, 
                    CONCAT('ID: ', OLD.id, ', Nome: ', OLD.nome, ', Descrição: ', OLD.descricao, ', Quantidade: ', COALESCE(OLD.quantidade, 0), ', Fornecedor: ', COALESCE(OLD.fornecedor, 0)),
                    CONCAT('ID: ', NEW.id, ', Nome: ', NEW.nome, ', Descrição: ', NEW.descricao, ', Quantidade: ', COALESCE(NEW.quantidade, 0), ', Fornecedor: ', COALESCE(NEW.fornecedor, 0))
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_after_update_produto");
    }
}