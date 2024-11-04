<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TgInsertLogInfoUsuario extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER tg_insert_log_info_usuario
            AFTER INSERT ON usuario
            FOR EACH ROW 
            BEGIN
                INSERT INTO logs (tabela, acao, data, usuario, dados_novos)
                VALUES (
                    'usuario',
                    'INSERT',
                    CURRENT_TIMESTAMP,
                    @current_user, 
                    CONCAT(
                        'ID: ', NEW.id,
                        ', Nível: ', COALESCE(NEW.nivel, 0),
                        ', Status do Registro: ', NEW.statusRegistro,
                        ', Nome: ', COALESCE(NEW.nome, ''),
                        ', Email: ', COALESCE(NEW.email, ''),
                        ', Primeiro Login: ', COALESCE(NEW.primeiroLogin, '0'),
                        ', ID Funcionário: ', COALESCE(NEW.id_funcionario, 0)
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