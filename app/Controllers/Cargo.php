<?php

namespace App\Controllers;

use App\Models\CargoModel;

use CodeIgniter\Database\Exceptions\DatabaseException;

class Cargo extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CargoModel();
        
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
                session()->setFlashdata('msgError', 'Erro: Não é possível excluir este cargo, pois ele está relacionado a outros dados.');
            } else {
                // Trata outros tipos de erro, se necessário
                session()->setFlashdata('msgError', 'Ocorreu um erro ao tentar excluir o cargo.');
            }
        }

        return redirect()->to(site_url('Cargo'));
    }
}
