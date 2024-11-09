<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends CustomModel
{
    protected $table            = 'usuario';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome', 'statusRegistro', 'email', 'nivel', 'senha', 'id_funcionario'];
    
    protected $validationRules = [
        'nome' => [
            'label' => 'Nome',
            'rules' => 'required|min_length[3]|max_length[50]'
        ],
        'email' => [
            'label' => 'E-mail',
            'rules' => 'required|valid_email|max_length[100]'
        ],
        'nivel' => [
            'label' => 'Nível',
            'rules' => 'required|integer'
        ],
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|integer'
        ]
    ];

    /**
     * Retorna a lista de usuários ordenada por nome.
     */
    public function getLista()
    {
        return $this->orderBy('nome')->findAll();
    }

    /**
     * Retorna um usuário pelo e-mail.
     * 
     * @param string $email
     * @return array|null
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Cria um super usuário se nenhum usuário existir.
     * 
     * @return int
     */
    public function insertDadosSuperUser()
    {
     
        $qtd = $this->countAllResults();
      
        if ($qtd == 0) {
        
            $data = [
                'nome' => 'administrador',
                'email' => 'administrador@gmail.com',
                'senha' => password_hash('admin', PASSWORD_DEFAULT),
                'nivel' => 1,
                'statusRegistro' => 1
            ];

            if ($this->insert($data)) {
                session()->set('msgSuccess', 'Super usuário criado com sucesso.');
                return 2; 
            } else {
          
                session()->set('msgError', 'Falha na inclusão do super usuário, não é possível prosseguir.');
                return 1; 
            }
        }

        return 0; 
    }

    /**
     * Retorna um usuário pelo ID.
     * 
     * @param int $id
     * @return array|null
     */
    public function getUserEmailAdm($id)
    {
        return $this->find($id);
    }
}
