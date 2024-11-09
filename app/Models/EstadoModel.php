<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services; 

class EstadoModel extends CustomModel
{
    protected $table            = 'estado';
    protected $primaryKey       = 'id'; 
    protected $allowedFields    = ['nome', 'sigla', 'statusRegistro'];
    protected $returnType       = 'array';

    /**
     * Lista estados
     *
     * @param string $orderBy
     * @return array
     */
    public function lista($orderBy = 'id')
    {
    
        $session = Services::session();
        
        if ($session->get('usuarioNivel') == 1) {
            return $this->orderBy($orderBy)->findAll();
        } else {
            return $this->where('statusRegistro', 1)
                        ->orderBy($orderBy)
                        ->findAll();
        }
    }
}
