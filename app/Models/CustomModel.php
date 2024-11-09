<?php 

namespace App\Models;

use CodeIgniter\Model;

class CustomModel extends Model
{
    protected $currentUser;

    /**
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->currentUser = session()->has('current_user') ? session()->get('current_user') : null;
    
    }

    /**
     * inserirMovimentacao function
     *
     * @param array $row
     * @param boolean $returnID
     * @return void
     */
    public function inserirMovimentacao($row = null, bool $returnID = true)
    {
        $currentUser = $this->currentUser;
        $this->db->query("SET @current_user = '{$currentUser}'");

        try {
            return $this->db->table('movimentacao')->insert($row, $returnID);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * insertMovimentacaoItem function
     *
     * @param array $row
     * @return void
     */
    public function insertMovimentacaoItem($row = null)
    {

        $currentUser = $this->currentUser;
        $this->db->query("SET @current_user = '{$currentUser}'");

        return $this->db->table('movimentacao_item')->insert($row);
    }

    /**
     * updateMovimentacaoQuantidade function
     *
     * @param int $id_movimentacao
     * @param int $id_produto
     * @param int $novaQuantidade
     * @param float $valor
     * @return void
     */
    public function updateMovimentacaoQuantidade($id_movimentacao, $id_produto, $novaQuantidade, $valor)
    {

        $this->db->query("SET @current_user = '{$this->currentUser}'");

        return $this->db->table('movimentacao_item')->where([
            'id_movimentacoes' => $id_movimentacao,
            'id_produtos' => $id_produto
        ])->set([
            'quantidade' => $novaQuantidade,
            'valor' => $valor
        ])->update();
        
    }

    /**
     * deleteMovimentacaoItemComQuantidadeZero function
     *
     * @param int $id_movimentacao
     * @param int $id_produto
     * @return void
     */
    public function deleteMovimentacaoItemComQuantidadeZero($id_movimentacao, $id_produto)
    {
    
        $this->db->query("SET @current_user = '{$this->currentUser}'");

        return $this->db->table('movimentacao_item')->delete([
            'id_movimentacoes' => $id_movimentacao,
            'id_produtos' => $id_produto,
            'quantidade' => 0
        ]);
    }
    
    /**
     * insert function
     *
     * @param array $row
     * @param boolean $returnID
     * @return void
     */
    public function insert($row = null, bool $returnID = true) 
    {
       
        $currentUser = $this->currentUser;
        $this->db->query("SET @current_user = '{$currentUser}'");

        return parent::insert($row, $returnID);
    }

    /**
     * update function
     *
     * @param int $id
     * @param array $data
     * @return boolean
     */
    public function update($id = null, $data = null): bool
    {

        $currentUser = $this->currentUser;
        $this->db->query("SET @current_user = '{$currentUser}'"); 

        return parent::update($id, $data);
    }
    
    /**
     * delete function
     *
     * @param int $id
     * @param boolean $purge
     * @return void
     */
    public function delete($id = null, bool $purge = false)
    {
       
        $currentUser = $this->currentUser;
        $this->db->query("SET @current_user = '{$currentUser}'"); 

        return parent::delete($id, $purge);
    }
}
