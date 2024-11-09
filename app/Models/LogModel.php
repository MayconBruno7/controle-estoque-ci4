<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Library\Session;

class LogModel extends CustomModel
{
    protected $table            = 'logs'; 
    protected $primaryKey       = 'id'; 
    protected $returnType       = 'array'; 
    protected $allowedFields    = ['*'];

    /**
     * Lista os logs, ordenados por uma coluna específica
     *
     * @param string $orderBy
     * @return array
     */
    public function lista(string $orderBy = 'id'): array
    {
        $query = $this->orderBy($orderBy, 'DESC');

        return $query->findAll();
    }
}
