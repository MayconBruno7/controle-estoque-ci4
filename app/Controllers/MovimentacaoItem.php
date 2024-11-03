<?php

namespace App\Controllers;

use App\Models\MovimentacaoItemModel;
use App\Models\SetorModel;
use App\Models\FornecedorModel;
use CodeIgniter\Controller;

class MovimentacaoItem extends BaseController
{
    protected $movimentacaoItemModel;
    protected $setorModel;
    protected $fornecedorModel;

    public function __construct()
    {
        // Carregando os modelos
        $this->movimentacaoItemModel    = new MovimentacaoItemModel();
        $this->setorModel               = new SetorModel();
        $this->fornecedorModel          = new FornecedorModel();
    }

    /**
     * form
     *
     * @return void
     */
    public function form($id = null)
    {
        $dados = [];

        if ($id !== null) {
            $dados = $this->movimentacaoItemModel->find($id);
        }

        $dados['aItemMovimentacao']         = $this->movimentacaoItemModel->listaProdutos($id);
        $dados['aSetorMovimentacao']        = $this->setorModel->findAll();
        $dados['aFornecedorMovimentacao']   = $this->fornecedorModel->findAll();

        return view("restrita/formMovimentacao", $dados);
    }

    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        $request    = \Config\Services::request();
        $post       = $request->getPost();

        if (!$this->validate($this->movimentacaoItemModel->validationRules)) {
            // Redireciona com erro de validação
            return redirect()->to("Movimentacao/form/update/{$post['id']}")->withInput()->with('errors', $this->validator->getErrors());
        } else {
            if ($this->movimentacaoItemModel->update($post['id'], [
                "nome" => $post['nome'],
                "statusRegistro" => $post['statusRegistro']
            ])) {
                session()->setFlashdata('msgSuccess', 'Movimentacao alterada com sucesso.');
            } else {
                session()->setFlashdata('msgError', 'Falha ao tentar alterar a Movimentacao.');
            }

            return redirect()->to("Movimentacao");
        }
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $request = \Config\Services::request();

        if ($this->movimentacaoItemModel->delete($request->getPost('id'))) {
            session()->setFlashdata('msgSuccess', 'Movimentacao excluída com sucesso.');
        } else {
            session()->setFlashdata('msgError', 'Falha ao tentar excluir a Movimentacao.');
        }

        return redirect()->to("Movimentacao");
    }
}
