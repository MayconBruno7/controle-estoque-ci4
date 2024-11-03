<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgAfterInsertProduto extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_after_insert_produto
            AFTER INSERT ON produto
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, usuario, dados_novos)
                VALUES ('produto', 'INSERT', @current_user, CONCAT('ID: ', NEW.id, ', Nome: ', NEW.nome, ', Descrição: ', NEW.descricao, ', Quantidade: ', NEW.quantidade, ', Fornecedor: ', NEW.fornecedor));
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_after_insert_produto");
    }
}