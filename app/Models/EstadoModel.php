<?php

namespace App\Models; // Certifique-se de que o namespace está correto

use CodeIgniter\Model;
use Config\Services; // Para acessar o serviço de sessão

class EstadoModel extends CustomModel
{
    protected $table            = 'estado'; // Usar 'protected' para que seja acessível em subclasses
    protected $primaryKey       = 'id'; // Defina a chave primária
    protected $allowedFields    = ['nome', 'sigla', 'statusRegistro']; // Adicione os campos permitidos
    protected $returnType       = 'array'; // Tipo de retorno das operações do modelo

    /**
     * Lista estados
     *
     * @param string $orderBy
     * @return array
     */
    public function lista($orderBy = 'id')
    {
        // Usar a classe de sessão do CodeIgniter 4
        $session = Services::session();
        
        // Se o nível do usuário for 1, retorna todos os estados
        if ($session->get('usuarioNivel') == 1) {
            return $this->orderBy($orderBy)->findAll();
        } else {
            // Retorna apenas os estados com statusRegistro ativo (1)
            return $this->where('statusRegistro', 1)
                        ->orderBy($orderBy)
                        ->findAll();
        }
    }
}
