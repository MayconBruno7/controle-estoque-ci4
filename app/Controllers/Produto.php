<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use App\Models\HistoricoProdutoModel;
use App\Models\FornecedorModel;
use CodeIgniter\Controller;

use CodeIgniter\Database\Exceptions\DatabaseException;

class Produto extends BaseController
{
    protected $model;
    protected $historicoProdutoModel;
    protected $fornecedorModel;

    /**
     * __construct
     */
    public function __construct()
    {
        // Carregando os modelos
        $this->model                    = new ProdutoModel();
        $this->historicoProdutoModel    = new HistoricoProdutoModel();
        $this->fornecedorModel          = new FornecedorModel();
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        if (empty($action)) {
            // Recuperando todos os segmentos da URL
            $segmentos = service('request')->getURI()->getSegments();
    
            // Acessando o terceiro segmento (index 2, já que começa em 0)
            $action     = $segmentos[2] ?? null;
            $id_produto = $segmentos[3] ?? null;            
        }
        
        if ($action != 'delete') {
            $data['produtos'] = $this->model->getLista("id", $action);
        } else {
            $data['produtos'] = $this->model->listaDeleteProduto($id_produto);
        }
        
        return view("restrita/listaProduto", $data);
    }

    /**
     * form
     *
     * @return void
     */
    public function form($action = null, $id = null)
    {
        $data['action'] = $action;
        $data['data']   = null;
        $data['errors'] = [];

        $data['aFornecedor']        = $this->fornecedorModel->findAll();
        $data['aHistoricoProduto']  = $this->historicoProdutoModel->historicoProduto($id, 'id');

        if ($action != "new" && $id !== null) {
            $data['data'] = $this->model->find($id);
        }

        return view("restrita/formProduto", $data);
    }

    /**
     * insert
     *
     * @return void
     */
    public function store()
    {
        $post = $this->request->getPost();

        if ($this->model->save([
            'id'                => ($post['id'] == "" ? null : $post['id']),
            "nome"              => $post['nome'],
            "quantidade"        => $post['quantidade'],
            "fornecedor"        => !empty($post['fornecedor_id']) ? $post['fornecedor_id'] : null,
            "statusRegistro"    => $post['statusRegistro'],
            "condicao"          => $post['condicao'],
            "descricao"         => $post['descricao'],
            "dataMod"           => date('Y-m-d H:i:s')  
        ])) {
            return redirect()->to("/Produto")->with('msgSuccess', "Dado inserido com sucesso!");
        } else {
            return view("restrita/formProduto", [
                'action'    => $post['action'],
                'data'      => $post,
                'errors'    => $this->model->errors()
            ]);
        }

        return redirect()->to("Produto");
    }


    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $id = $this->request->getPost('id');

        try {
            // Tenta deletar o produto
            if ($this->model->delete($id)) {
                session()->setFlashdata('msgSuccess', 'Produto excluído com sucesso.');
            } else {
                session()->setFlashdata('msgError', 'Falha ao tentar excluir o produto.');
            }
        } catch (DatabaseException $e) {
            // Verifica se o erro é uma violação de chave estrangeira
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                session()->setFlashdata('msgError', 'Erro: Não é possível excluir este fonecedor, pois ele está relacionado a outros dados.');
            } else {
                // Trata outros tipos de erro, se necessário
                session()->setFlashdata('msgError', 'Ocorreu um erro ao tentar excluir o produto.');
            }
        }

        return redirect()->to("Produto");
    }
}
