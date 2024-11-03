<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioRecuperaSenhaModel extends Model
{
    protected $table = 'usuariorecuperasenha';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario_id', 'chave', 'statusRegistro', 'created_at'];

    /**
     * getRecuperaSenhaChave - Recupera os dados do usuário pela chave
     *
     * @param string $chave
     * @return array|null
     */
    public function getRecuperaSenhaChave($chave)
    {
        return $this->where(['statusRegistro' => 1, 'chave' => $chave])
                    ->first();
    }

    /**
     * desativaChave - Desativa a chave de acesso específica
     *
     * @param int $id
     * @return bool
     */
    public function desativaChave($id)
    {
        return $this->update($id, ['statusRegistro' => 2]);
    }

    /**
     * desativaChaveAntigas - Desativa todas as chaves de acesso antigas
     *
     * @param int $usuario_id
     * @return bool
     */
    public function desativaChaveAntigas($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)
                    ->where('statusRegistro', 1)
                    ->set('statusRegistro', 2)
                    ->update();
    }
}
