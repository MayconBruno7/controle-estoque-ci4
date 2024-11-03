<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracoesModel extends CustomModel
{
    protected $table = 'configuracoes';
    protected $primaryKey = 'id';

    protected $allowedFields = ['chave', 'valor', 'descricao', 'criado_em', 'atualizado_em'];

    // protected $useTimestamps = true;
    // protected $useSoftDeletes = true;


     /**
     * 
     * 
     * @return array
     */
    public function getAdmEmail($chave = 'emailAdm')
    {
        $builder = $this->db->table($this->table);

        if (session()->get('usuarioNivel') == 1) {
            $builder->where('chave', $chave);
        } else {
            $builder->where(['chave' => $chave]);
        }

        return $builder->get()->getResultArray();
    }
}