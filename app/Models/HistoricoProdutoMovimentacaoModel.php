<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoricoProdutoMovimentacaoModel extends CustomModel
{
    protected $table            = 'movimentacao_item'; // Define a tabela do banco de dados
    protected $primaryKey       = 'id'; // Define a chave primária
    protected $returnType       = 'array'; // Define o tipo de retorno
    protected $allowedFields    = [
        'id_movimentacoes',
        'id_produtos',
        'quantidade',
        'valor'
    ]; // Campos permitidos para inserção e atualização

    /**
     * Recupera o histórico de movimentação de um produto
     *
     * @param int $id_produto
     * @return array
     */
    public function historicoProdutoMovimentacao(int $id_produto)
    {
        return $this->select('m.id AS id_mov, f.nome AS nome_fornecedor, m.tipo, m.data_pedido, m.data_chegada, p.nome AS nome_produto, SUM(movi.quantidade) AS Quantidade, SUM(movi.valor) AS Valor')
            ->from('movimentacao m')
            ->join('fornecedor f', 'f.id = m.id_fornecedor')
            ->join($this->table . ' movi', 'movi.id_movimentacoes = m.id')
            ->join('produto p', 'p.id = movi.id_produtos')
            ->where('movi.id_produtos', $id_produto)
            ->groupBy(['m.id', 'f.nome', 'm.tipo', 'm.data_pedido', 'm.data_chegada', 'p.nome'])
            ->findAll();
    }
}
