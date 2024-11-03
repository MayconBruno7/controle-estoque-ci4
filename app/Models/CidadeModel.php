<?php

namespace App\Models; // Certifique-se de que o namespace está correto

use CodeIgniter\Model;
use Config\Services; // Para acessar o serviço de sessão

class CidadeModel extends CustomModel
{
    protected $table            = 'cidade'; // Usar 'protected' para que seja acessível em subclasses
    protected $primaryKey       = 'id'; // Defina a chave primária
    protected $allowedFields    = ['nome', 'estado', 'statusRegistro']; // Adicione os campos permitidos
    protected $returnType       = 'array'; // Tipo de retorno das operações do modelo

    /**
     * Lista cidades
     *
     * @param string $orderBy
     * @return array
     */
    public function lista($orderBy = 'id')
    {
        // Usar a classe de sessão do CodeIgniter 4
        $session = Services::session();
        
        // Se o nível do usuário for 1, retorna todas as cidades
        if ($session->get('usuarioNivel') == 1) {
            return $this->orderBy($orderBy)->findAll();
        } else {
            // Retorna apenas as cidades com statusRegistro ativo (1)
            return $this->where('statusRegistro', 1)
                        ->orderBy($orderBy)
                        ->findAll();
        }
    }
}
