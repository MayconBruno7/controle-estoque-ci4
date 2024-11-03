<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends CustomModel
{
    protected $table            = 'produto';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['descricao', 'condicao', 'nome', 'statusRegistro', 'quantidade', 'dataMod', 'fornecedor', 'tipo_produto'];

    protected $validationRules = [
        'descricao'         => 'required|min_length[3]|max_length[50]',
        'condicao'          => 'required',
        'nome'              => 'required',
        'statusRegistro'    => 'required|integer'
    ];

    /**
     * Lista todos os produtos.
     *
     * @param string $orderBy
     * @return array
     */
    public function getLista($orderBy = 'id')
    {
        $builder = $this->db->table($this->table);

        if (session()->get('usuarioNivel') == 1) {
            $builder->select("produto.*, (SELECT valor FROM movimentacao_item WHERE id_produtos = produto.id LIMIT 1) AS valor");
        } else {
            $builder->select("produto.*, (SELECT valor FROM movimentacao_item WHERE id_produtos = produto.id LIMIT 1) AS valor")
                    ->where('statusRegistro', 1)
                    ->where('quantidade >', 0);
        }

        return $builder->orderBy($orderBy, 'DESC')->get()->getResultArray();
    }

    /**
     * Lista um produto específico pelo ID.
     *
     * @param int $id_produto
     * @return array
     */
    public function listaDeleteProduto($id_produto)
    {
        $builder = $this->db->table($this->table);

        if (session()->get('usuarioNivel') == 1) {
            $builder->where('id', $id_produto);
        } else {
            $builder->where(['id' => $id_produto, 'statusRegistro' => 1]);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Recupera um produto pelo ID.
     *
     * @param int $idProduto
     * @return array
     */
    public function recuperaProduto($idProduto)
    {
        return $this->find($idProduto);
    }

    /**
     * Atualiza a movimentação de um produto.
     *
     * @param int $id_produto
     * @param int $id_movimentacao
     * @param int $tipo_movimentacao
     * @param array $infoProduto
     * @return bool
     */
    public function updateProduto($id_produto, $id_movimentacao, $tipo_movimentacao, $infoProduto)
    {
        $produto = $this->recuperaProduto($id_produto);

        if ($produto) {
            $quantidadeAtual = $produto['quantidade'];
            $attquantidade = ($tipo_movimentacao == 1) ? $quantidadeAtual + $infoProduto['quantidade'] : $quantidadeAtual - $infoProduto['quantidade'];

            $this->update($id_produto, ['quantidade' => $attquantidade]);

            foreach ($infoProduto as $item) {
                $this->db->table('movimentacao_item')
                    ->where(['id_movimentacoes' => $id_movimentacao, 'id_produtos' => $id_produto])
                    ->update(['quantidade' => $item]);
            }

            return true;
        }

        return false;
    }

    /**
     * Insere um histórico de produto.
     *
     * @param array $item
     * @return void
     */
    public function insertHistoricoProduto($item)
    {
        $this->db->table('historico_produto')->insert($item);
    }
}
