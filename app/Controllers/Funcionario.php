<?php

namespace App\Controllers;

use App\Models\FuncionarioModel;
use App\Models\SetorModel;
use App\Models\CargoModel;

use App\Libraries\UploadImages;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Funcionario extends BaseController
{
    protected $model;
    protected $setorModel;
    protected $cargoModel;

    public function __construct()
    {
        $this->model        = new FuncionarioModel(); 
        $this->setorModel   = new SetorModel();
        $this->cargoModel   = new CargoModel();

    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $data['funcionarios'] = $this->model->getLista(); 
        return view('restrita/listaFuncionario', $data);
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
        
        $data['aSetor'] = $this->setorModel->getLista();
        $data['aCargo'] = $this->cargoModel->getLista(); 

        if ($action != "new" && $id !== null) {
            $data['data'] = $this->model->find($id); 
        }

        return view('restrita/formFuncionario', $data);
    }

    /**
     * store
     *
     * @return void
     */
    public function store()
    {
        $post = $this->request->getPost();

        if (!empty($_FILES['imagem']['name'])) {
            $nomeRetornado = UploadImages::upload($_FILES, 'funcionarios');

            if ($post['nomeImagem']) {
                UploadImages::delete($post['nomeImagem'], 'funcionarios');
            }
            
        } else {
            $nomeRetornado = $post['nomeImagem'];
        }

        if ($this->model->save([
            'id'                => ($post['id'] == "" ? null : $post['id']),
            'nome'              => $post['nome'],
            'cpf'               => preg_replace("/[^0-9]/", "", $post['cpf']),
            'telefone'          => preg_replace("/[^0-9]/", "", $post['telefone']),
            'setor'             => !empty($post['setor']) ? $post['setor'] : null,
            'cargo'             => !empty($post['cargo']) ? $post['cargo'] : null,
            'salario'           => preg_replace("/[^0-9,]/", "", $post['salario']),
            'statusRegistro'    => $post['statusRegistro'],
            'imagem'            => $nomeRetornado  
        ])) {

            return redirect()->to("/Funcionario")->with('msgSuccess', "Funcionário inserido com sucesso!");

        } else {

            return view("restrita/formFuncionario", [
                'action'    => $post['action'],
                'data'      => $post,
                'aSetor'    => $this->setorModel->getLista(),
                'aCargo'    => $this->cargoModel->getLista(),
                'errors'    => $this->model->errors()
            ]);
        }
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();

        try {
            if ($this->model->delete($post['id'])) {
                session()->setFlashdata('msgSuccess', 'funcionário excluído com sucesso.');
            } else {
                session()->setFlashdata('msgError', 'Falha ao tentar excluir o funcionário.');
            }
        } catch (DatabaseException $e) {
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                session()->setFlashdata('msgError', 'Erro: Não é possível excluir este fonecedor, pois ele está relacionado a outros dados.');
            } else {
                session()->setFlashdata('msgError', 'Ocorreu um erro ao tentar excluir o funcionário.');
            }
        }

        return redirect()->to(base_url('Funcionario'));
    }
}
