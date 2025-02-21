<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgUpdateProdutoAddHistorico extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER after_update_produto_historico
            AFTER UPDATE ON produto
            FOR EACH ROW
            BEGIN
                INSERT INTO historico_produto (
                    id_produtos,
                    fornecedor_id,
                    nome_produtos,
                    descricao_anterior,
                    quantidade_anterior,
                    status_anterior,
                    statusItem_anterior,
                    dataMod
                )
                VALUES (
                    OLD.id,            
                    OLD.fornecedor,      
                    OLD.nome,             
                    OLD.descricao,       
                    0,                   
                    OLD.statusRegistro, 
                    OLD.condicao,         
                    NOW()                
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS after_update_produto_historico");
    }
}