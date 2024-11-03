<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoricoProdutoModel extends CustomModel
{
    protected $table            = 'historico_produto'; // Define a tabela do banco de dados
    protected $primaryKey       = 'id'; // Define a chave primária
    protected $returnType       = 'array'; // Define o tipo de retorno
    protected $allowedFields    = [
        'id_produtos',
        'fornecedor_id',
        'nome_produtos',
        'descricao_anterior',
        'quantidade_anterior',
        'status_anterior',
        'statusItem_anterior',
        'dataMod',
    ]; // Campos permitidos para inserção e atualização

    /**
     * Recupera o histórico do produto com base no ID do produto
     *
     * @param int $idProduto
     * @param string $orderBy
     * @return array
     */
    public function historicoProduto(int $idProduto, string $orderBy = 'id'): array
    {
        return $this->where('id_produtos', $idProduto)
                    ->orderBy($orderBy)
                    ->findAll();
    }

    /**
     * Recupera o histórico de produtos com base em um termo de pesquisa
     *
     * @param string $termo
     * @return array
     */
    public function getHistoricoProduto($dataMod): array
    {
      
        if (!empty($dataMod)) {
            // Seleciona apenas as colunas necessárias
            return $this->select('id, id_produtos, fornecedor_id, nome_produtos, descricao_anterior, quantidade_anterior, status_anterior, statusItem_anterior, dataMod')
                        ->like('dataMod', $dataMod)
                        ->findAll();
        }
    
        return [];
    }
}
