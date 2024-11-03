<?php

namespace App\Controllers;

use App\Models\model;
use App\Models\FuncionarioModel;
use App\Models\SetorModel;
use CodeIgniter\Controller;

class Setor extends BaseController
{
    protected $model;
    protected $funcionarioModel;

    public function __construct()
    {
        $this->model            = new SetorModel();
        $this->funcionarioModel = new FuncionarioModel();

        // Só acessa se tiver logado
        if (!$this->getUsuario()) {
            return redirect()->to('/home');
        }
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

        if ($this->model->delete($post['id'])) {
            return redirect()->to("/Setor")->with("msgSuccess", "Funcionário excluído com sucesso!");
        } else {
            return redirect()->to("/Setor")->with("msgError", "Falha ao excluir o funcionário!");        
        }

        return redirect()->to('Setor');
    }
}
