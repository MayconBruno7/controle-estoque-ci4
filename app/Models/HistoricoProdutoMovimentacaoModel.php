<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoricoProdutoMovimentacaoModel extends CustomModel
{
    protected $table            = 'movimentacao_item'; 
    protected $primaryKey       = 'id'; 
    protected $returnType       = 'array'; 
    protected $allowedFields    = [
        'id_movimentacoes',
        'id_produtos',
        'quantidade',
        'valor'
    ]; 

    /**
     * Recupera o histórico de movimentação de um produto
     *
     * @param int $id_produto
     * @return array
     */
    public function historicoProdutoMovimentacao(int $id_produto)
    {
        return $this->select('m.id AS id_mov, f.nome AS nome_fornecedor, m.tipo, m.data_pedido, m.data_chegada, p.nome AS nome_produto, SUM(DISTINCT movi.quantidade) AS Quantidade, SUM(DISTINCT movi.quantidade) * SUM(DISTINCT movi.valor) AS Valor')
            ->from('movimentacao m')
            ->join('fornecedor f', 'f.id = m.id_fornecedor')
            ->join($this->table . ' movi', 'movi.id_movimentacoes = m.id')
            ->join('produto p', 'p.id = movi.id_produtos')
            ->where('movi.id_produtos', $id_produto)
            ->groupBy(['m.id', 'f.nome', 'm.tipo', 'm.data_pedido', 'm.data_chegada', 'p.nome'])
            ->findAll();
    }
}
