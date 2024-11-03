<?php

namespace App\Controllers;

use App\Models\CargoModel;

class Cargo extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CargoModel();
        
        // Verifica se o usuário é administrador antes de permitir o acesso
        if (!$this->getAdministrador()) {
            return redirect()->to(site_url("Home"));
        }
    }

    /**
     * Exibe a lista de cargos
     */
    public function index()
    {
        $data['cargos'] = $this->model->orderBy('id')->findAll();
        return view('restrita/listaCargo', $data);
    }

    /**
     * Formulário de inserção/edição de cargos
     */
    public function form($action = null, $id = null)
    {

        $data['action'] = $action;
        $data['data']   = null;
        $data['errors'] = [];

        if ($action !== 'new' && $id !== null) {
            $data['data'] = $this->model->find($id);
        }

        return view('restrita/formCargo', $data);
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
            'id' => ($post['id'] == "" ? null : $post['id']),
            'nome' => $post['nome'],
            'statusRegistro' => $post['statusRegistro']
        ])) {
            return redirect()->to("/Cargo")->with('msgSuccess', "Funcionário inserido com sucesso!");
        } else {

            return view("restrita/formCargo", [
                'action' => $post['action'],
                'data' => $post,
                'errors' => $this->model->errors()
            ]);
        }
    }

    /**
     * Exclui um cargo
     */
    public function delete()
    {
        $post = $this->request->getPost();

        if ($this->model->delete($post['id'])) {
            session()->set('msgSuccess', 'Cargo excluída com sucesso.');
        } else {
            session()->set('msgError', 'Falha ao tentar excluir a Cargo.');
        }

        return redirect()->to(site_url('Cargo'));
    }
}
