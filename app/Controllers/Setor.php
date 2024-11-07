<?php

namespace App\Controllers;

use App\Models\model;
use App\Models\FuncionarioModel;
use App\Models\SetorModel;
use CodeIgniter\Controller;

use CodeIgniter\Database\Exceptions\DatabaseException;

class Setor extends BaseController
{
    protected $model;
    protected $funcionarioModel;

    public function __construct()
    {
        $this->model            = new SetorModel();
        $this->funcionarioModel = new FuncionarioModel();
    }

    public function index()
    {
        $data['setores'] = $this->model->getLista("id");
        return view('restrita/listaSetor', $data);
    }

    public function form($action = null, $id = null)
    {
        $data['data']   = null;
        $data['errors'] = [];
        $data['action'] = $action;
        
        $data['aFuncionario'] = $this->funcionarioModel->getLista(); 

        // Se não for uma nova entrada e um ID válido for fornecido
        if ($action != "new" && $id !== null) {
            $data['data'] = $this->model->find($id); // Busca o funcionário pelo ID
        }

        return view('restrita/formSetor', $data);
    }

    /**
     * store
     *
     * @return void
     */
    public function store()
    {
        $post = $this->request->getPost();

        if ($this->model->save([
            'id'                => ($post['id'] == "" ? null : $post['id']),
            "nome"              => $post['nome'],
            "responsavel"       => $post['funcionarios'],
            "statusRegistro"    => $post['statusRegistro']
        ])) {
            return redirect()->to("/Setor")->with('msgSuccess', "Funcionário inserido com sucesso!");
        } else {
            return view("restrita/formSetor", [
                'action'        => $post['action'],
                'data'          => $post,
                'aFuncioanrio'  => $this->funcionarioModel->getLista(),
                'errors'        => $this->model->errors()
            ]);
        }

    }


    public function delete()
    {
        $post = $this->request->getPost();

        try {
            // Tenta deletar o cargo
            if ($this->model->delete($post['id'])) {
                session()->setFlashdata('msgSuccess', 'Cargo excluído com sucesso.');
            } else {
                session()->setFlashdata('msgError', 'Falha ao tentar excluir o cargo.');
            }
        } catch (DatabaseException $e) {
            // Verifica se o erro é uma violação de chave estrangeira
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                session()->setFlashdata('msgError', 'Erro: Não é possível excluir este setor, pois ele está relacionado a outros dados.');
            } else {
                // Trata outros tipos de erro, se necessário
                session()->setFlashdata('msgError', 'Ocorreu um erro ao tentar excluir o cargo.');
            }
        }

        return redirect()->to('Setor');
    }
}
