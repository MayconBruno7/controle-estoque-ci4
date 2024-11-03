<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Library\Session;

class LogModel extends CustomModel
{
    protected $table            = 'logs'; // Define a tabela do banco de dados
    protected $primaryKey       = 'id'; // Define a chave primária
    protected $returnType       = 'array'; // Define o tipo de retorno
    protected $allowedFields    = ['*']; // Permite todos os campos (ajuste conforme necessário)

    /**
     * Lista os logs, ordenados por uma coluna específica
     *
     * @param string $orderBy
     * @return array
     */
    public function lista(string $orderBy = 'id'): array
    {
        // Verifica o nível do usuário
        $query = $this->orderBy($orderBy, 'DESC');

        // Recupera todos os registros
        return $query->findAll();
    }
}
