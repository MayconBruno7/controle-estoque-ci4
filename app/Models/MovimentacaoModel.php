<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class MovimentacaoModel extends CustomModel
{
    protected $table            = 'movimentacao';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_fornecedor', 'tipo', 'statusRegistro', 'id_setor', 'data_pedido', 'data_chegada', 'motivo'];
    
    protected $validationRules  = 
    [
        'setor_id' => [
            'label' => 'Setor',
            'rules' => 'required|integer'
        ],
        'fornecedor_id' => [
            'label' => 'Fornecedor',
            'rules' => 'required|integer'
        ],
        'tipo' => [
            'label' => 'Tipo',
            'rules' => 'required|integer'
        ],
        'data_pedido' => [
            'label' => 'Data do Pedido',
            'rules' => 'required|valid_date'
        ],
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|integer'
        ],

    ];

    /**
     * Lista movimentações
     *
     * @param string $orderBy
     * @return array
     */
    public function getLista($orderBy = 'm.id'): array
    {

        $builder = $this->db->table($this->table . ' m')
        ->select('
            m.id AS id_movimentacao,
            f.nome AS nome_fornecedor,
            m.tipo AS tipo_movimentacao,
            m.id_fornecedor,
            m.id_setor,
            m.motivo,
            m.data_pedido,
            m.data_chegada,
            m.statusRegistro')
        ->join('fornecedor f', 'f.id = m.id_fornecedor', 'left');

        if (session()->get('usuarioNivel') != 1) {
            $builder->where('m.statusRegistro', 1);
        }

        return $builder->orderBy($orderBy, 'DESC')->get()->getResultArray();
    }

    public function getMovimentacaoDetalhada(int $id_movimentacao): array
    {
        
        $builder = $this->db->table('movimentacao m')
            ->select('
                m.id AS id_movimentacao,
                m.tipo AS tipo_movimentacao,
                m.id_fornecedor,
                m.id_setor,
                m.motivo,
                m.data_pedido,
                m.data_chegada,
                m.statusRegistro,
                f.nome AS nome_fornecedor,
                mi.id AS id_movimentacao_item,
                mi.id_produtos,
                mi.quantidade,
                mi.valor,
                p.nome AS produto_nome,
                p.descricao AS produto_descricao
            ')
            ->join('fornecedor f', 'f.id = m.id_fornecedor', 'left')
            ->join('movimentacao_item mi', 'mi.id_movimentacoes = m.id', 'left')
            ->join('produto p', 'p.id = mi.id_produtos', 'left')
            ->where('m.id', $id_movimentacao);
        
        if (session()->get('usuarioNivel') != 1) {
            $builder->where('m.statusRegistro', 1);
        }

        return $builder->get()->getResultArray();
    }


    /**
     * Retorna o ID da última movimentação
     *
     * @return array
     */
    public function idUltimaMovimentacao()
    {
        return $this->selectMax('id', 'ultimo_id')->findAll();
    }

    /**
     * Insere uma nova movimentação
     *
     * @param array $movimentacao
     * @param array $aProdutos
     * @return bool
     */
    public function insertMovimentacao($movimentacao, $aProdutos)
    {
    
        $this->inserirMovimentacao($movimentacao);

        
        $ultimoRegistro = $this->insertID(); 
        
        if ($ultimoRegistro > 0) {
            if (!empty($aProdutos) && isset($aProdutos[0]['id_produtos']) && $aProdutos[0]['id_produtos'] != '') {
                foreach ($aProdutos as $item) {
                    $item['id_movimentacoes'] = $ultimoRegistro;
                    
                    $this->insertMovimentacaoItem($item);
                }
            }
            
            return true; 
        }
        
        return false;
    }

    /**
     * Atualiza uma movimentação existente
     *
     * @param int $idMovimentacao
     * @param array $movimentacao
     * @param array $aProdutos
     * @param bool $prod_info_mov_atualizado
     * @return bool
     */
    public function updateMovimentacao(int $idMovimentacao, $movimentacao, $prod_info_mov_atualizado)
    {
       
        if ($idMovimentacao) {
            if (empty($movimentacao)) {
                throw new \Exception("O array 'movimentacao' está vazio."); 
            }
    
            $updated = $this->update($idMovimentacao, $movimentacao);
            
            if (!$updated) {
                throw new \Exception("Falha na atualização da movimentação.");
            } else {
                return true;
            }
    
            if ($prod_info_mov_atualizado) {
                // if (session()->has('prod_mov_atualizado')) { 
                //     session()->set('prod_mov_atualizado', false);
                // }
  
                return true; 
            }
        }
        return false;
    }
    


    /**
     * Atualiza informações do produto na movimentação
     *
     * @param int $id_movimentacao
     * @param array $aProdutos
     * @param array $acao
     * @param int $quantidade_produto
     * @param int|null $quantidade_movimentacao
     * @return bool
     */
    public function updateInformacoesProdutoMovimentacao(int $id_movimentacao, array $aProdutos, array $acao, int $quantidade_produto, int $quantidade_movimentacao = null)
    {

        $id_produto = $aProdutos[0]['id_produtos'] ?? '';
        $valor      = $aProdutos[0]['valor'] ?? '';

        if ($id_movimentacao && !empty($id_produto)) {
            foreach ($aProdutos as $item) {
                if ($acao['acaoProduto'] == 'update') {
                    $item['quantidade'] = $quantidade_movimentacao;
                    $item['valor']      = $valor;

                    $produto_atualizado = $this->updateMovimentacaoQuantidade(
                        $id_movimentacao,
                        $id_produto,
                        $item['quantidade'],
                        $item['valor']
                    );

                    if($produto_atualizado){
                        session()->set('prod_mov_atualizado', true);
                        return true;
                    } else {
                        return false;
                    }

                } elseif ($acao['acaoProduto'] == 'new') {
                    $item['id_movimentacoes'] = $id_movimentacao;
                    $item['quantidade'] = $quantidade_movimentacao;

                    $produto_inserido = $this->insertMovimentacaoItem($item);

                    if($produto_inserido){
                        session()->set('prod_mov_atualizado', true);
                        return true;
                    } else {
                        return false;
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Remove informações do produto na movimentação
     *
     * @param int $id_movimentacao
     * @param array $aProdutos
     * @param int $tipo_movimentacao
     * @param int $quantidadeRemover
     * @return bool
     */
    public function deleteInfoProdutoMovimentacao(int $id_movimentacao, array $aProdutos, int $tipo_movimentacao, int $quantidadeRemover)
    {

        $item_movimentacao = $this->db->table('movimentacao_item')->where([
            'id_movimentacoes' => $id_movimentacao,
            'id_produtos' => $aProdutos['id']
        ])->get()->getRowArray();

        if ($item_movimentacao) {
            $quantidadeAtual = $item_movimentacao['quantidade'];

            if ($quantidadeRemover <= $quantidadeAtual) {
                $novaQuantidadeMovimentacao = $quantidadeAtual - $quantidadeRemover;

                $this->updateMovimentacaoQuantidade($id_movimentacao, $item_movimentacao['id_produtos'], $novaQuantidadeMovimentacao, $aProdutos['valor']);

                $this->deleteMovimentacaoItemComQuantidadeZero($id_movimentacao, $item_movimentacao['id_produtos']);

                return true;
            } else {
                session()->set('msgError', 'Quantidade maior que a da movimentação.');
                return false;
            }
        } else {
            session()->set('msgError', 'Item não encontrado na movimentação.');
            return false;
        }
    }

    /**
     * Obtém produtos para o combobox
     *
     * @param string $termo
     * @return array
     */
    public function getProdutoCombobox(string $termo)
    {
        if (!empty($termo)) {
            $produtos = $this->db->table('produto')->where('statusRegistro', 1)
                ->like('nome', $termo)
                ->get()->getResultArray();

            return array_map(function ($produto) {
                return [
                    'id' => $produto['id'],
                    'nome' => $produto['nome']
                ];
            }, $produtos);
        }
        return [];
    }

    public function verificaQuantidadeNegativaEstoque($sessao_produtos, $produto_model, $tipo_movimentacao) {

        $estoque_negativo = false;
        
        foreach($sessao_produtos as $produto) {
            
            if($produto['id_produto'] && $tipo_movimentacao == '2') {
                $info_produto = $produto_model->recuperaProduto($produto['id_produto']);

                if (($info_produto['quantidade'] - $produto['quantidade']) < 0) {
                    $estoque_negativo = true;
                    // quantidade em estoque ficara negativa
                }
            }

        }
        return $estoque_negativo;
    }
}
