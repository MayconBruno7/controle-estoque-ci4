<?php

namespace App\Models;

use CodeIgniter\Model;

class CargoModel extends CustomModel
{
    protected $table = 'cargo'; // Use 'protected' para que seja acessível em subclasses
    protected $primaryKey = 'id'; // Defina a chave primária
    protected $allowedFields = ['nome', 'statusRegistro']; // Campos que podem ser manipulados
    protected $validationRules = [
        'nome' => [
            'label' => 'Nome',
            'rules' => 'required|min_length[3]|max_length[50]'
        ],
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|integer'
        ]
    ];
    
    /**
     * Lista cargos
     *
     * @param string $orderBy 
     * @return array
     */
    public function getLista($orderBy = 'id')
    {
        // Usar a classe de sessão do CodeIgniter 4
        $session = \Config\Services::session();
        
        if ($session->get('usuarioNivel') == 1) {
            return $this->orderBy($orderBy, 'DESC')->findAll();
        } else {
            return $this->where('statusRegistro', 1)
                        ->orderBy($orderBy, 'DESC')
                        ->findAll();
        }
    }
}
