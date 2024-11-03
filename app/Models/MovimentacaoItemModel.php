<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimentacaoItemModel extends CustomModel
{
    protected $table            = 'movimentacao_item'; // Define a tabela do banco de dados
    protected $primaryKey       = 'id'; // Define a chave primária
    // protected $returnType = 'array'; // Define o tipo de retorno
    protected $allowedFields    = ['*']; // Permite todos os campos (ajuste conforme necessário)

    /**
     * Lista produtos relacionados a uma movimentação
     *
     * @param int $id_movimentacao
     * @return array
     */
    public function listaProdutos(int $id_movimentacao)
    {
        $query = $this->db->table($this->table . ' mi')
            ->select('mi.id_movimentacoes, mi.id_produtos AS id_prod_mov_itens, mi.quantidade AS mov_itens_quantidade, mi.valor, p.*, m.tipo')
            ->join('produto p', 'p.id = mi.id_produtos')
            ->join('movimentacao m', 'm.id = mi.id_movimentacoes')
            ->where('mi.id_movimentacoes', $id_movimentacao)
            ->orWhere('mi.id_movimentacoes IS NULL')
            ->orderBy('p.descricao');

        return $query->get()->getResultArray(); // Retorna os resultados como um array
    }
}
