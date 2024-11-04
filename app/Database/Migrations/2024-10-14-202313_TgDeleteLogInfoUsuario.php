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
                    @current_user, 
                    CONCAT(
                        'id: ', OLD.id,
                        ', nivel: ', OLD.nivel,
                        ', statusRegistro: ', OLD.statusRegistro,
                        ', nome: ', OLD.nome,
                        ', email: ', OLD.email,
                        ', primeiroLogin: ', coalesce(OLD.primeiroLogin, 0),
                        ', id_funcionario: ', coalesce(OLD.id_funcionario, 0)
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