<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use App\Models\HistoricoProdutoModel;
use App\Models\FornecedorModel;
use CodeIgniter\Controller;

class Produto extends BaseController
{
    protected $model;
    protected $historicoProdutoModel;
    protected $fornecedorModel;

    public function __construct()
    {
        // Carregando os modelos
        $this->model                    = new ProdutoModel();
        $this->historicoProdutoModel    = new HistoricoProdutoModel();
        $this->fornecedorModel          = new FornecedorModel();

        // Verifica se o usuário está logado
        if (!$this->getUsuario()) {
            return redirect()->to("Home/login");
        }
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
            "fornecedor"        => $post['fornecedor_id'],
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

        if ($this->model->delete($id)) {
            session()->setFlashdata('msgSuccess', "Produto excluída com sucesso.");
        } else {
            session()->setFlashdata('msgError', "Falha ao tentar excluir a Produto.");
        }

        return redirect()->to("Produto");
    }
}
