<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTriggerUpdateLogInfoUsuario extends Migration
{
    public function up()
    {
        $sql = "CREATE TRIGGER tg_update_log_info_usuario 
                AFTER UPDATE ON usuario 
                FOR EACH ROW 
                BEGIN
                    INSERT INTO logs (tabela, acao, data, usuario, dados_antigos, dados_novos)
                    VALUES (
                        'usuario',
                        'UPDATE',
                        CURRENT_TIMESTAMP,
                        @current_user, 
                        CONCAT(
                            '{\"id\":', OLD.id, ', ',
                            '\"nivel\":\"', OLD.nivel, '\", ',
                            '\"statusRegistro\":', OLD.statusRegistro, ', ',
                            '\"nome\":\"', OLD.nome, '\", ',
                            '\"email\":\"', OLD.email, '\", ',
                            '\"primeiroLogin\":', OLD.primeiroLogin, ', ',
                            '\"id_funcionario\":', OLD.id_funcionario, '}'
                        ),
                        CONCAT(
                            '{\"id\":', NEW.id, ', ',
                            '\"nivel\":\"', NEW.nivel, '\", ',
                            '\"statusRegistro\":', NEW.statusRegistro, ', ',
                            '\"nome\":\"', NEW.nome, '\", ',
                            '\"email\":\"', NEW.email, '\", ',
                            '\"primeiroLogin\":', NEW.primeiroLogin, ', ',
                            '\"id_funcionario\":', NEW.id_funcionario, '}'
                        )
                    );
                END";

        $this->db->query($sql);
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS tg_update_log_info_usuario");
    }
}
