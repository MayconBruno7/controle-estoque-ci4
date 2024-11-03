<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgAfterDeleteProduto extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_after_delete_produto
            AFTER DELETE ON produto
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, usuario, dados_antigos)
                VALUES ('produto', 'DELETE', @current_user, CONCAT('ID: ', OLD.id, ', Nome: ', OLD.nome, ', Descrição: ', OLD.descricao, ', Quantidade: ', OLD.quantidade, ', Fornecedor: ', OLD.fornecedor));
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_after_delete_produto");
    }
}