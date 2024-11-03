<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoUsuario extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_usuario AFTER INSERT ON usuario FOR EACH ROW BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_novos)
                VALUES (
                    'usuario',
                    'INSERT',
                    CURRENT_TIMESTAMP,
                    @current_user, -- Substitua com a lógica para obter o usuário atual
                    CONCAT(
                        '{\"id\":', NEW.id, ', ',
                        '\"nivel\":', NEW.nivel, ', ',
                        '\"statusRegistro\":', NEW.statusRegistro, ', ',
                        '\"nome\":', NEW.nome, ', ',
                        '\"email\":', NEW.email, ', ',
                        '\"primeiroLogin\":', NEW.primeiroLogin, ', ',
                        '\"id_funcionario\":', NEW.id_funcionario, '}'
                    )
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_insert_log_info_usuario");
    }
}
