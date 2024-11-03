<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgDeleteLogInfoUsuario extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_delete_log_info_usuario
            AFTER DELETE ON usuario
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_antigos)
                VALUES (
                    'usuario',
                    'DELETE',
                    CURRENT_TIMESTAMP,
                    @current_user, -- Substitua com a lógica para obter o usuário atual
                    CONCAT(
                        '{\"id\":', OLD.id, ', ',
                        '\"nivel\":', OLD.nivel, ', ',
                        '\"statusRegistro\":', OLD.statusRegistro, ', ',
                        '\"nome\":', OLD.nome, ', ',
                        '\"email\":', OLD.email, ', ',
                        '\"primeiroLogin\":', OLD.primeiroLogin, ', ',
                        '\"id_funcionario\":', OLD.id_funcionario, '}'
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_delete_log_info_usuario");
    }
}