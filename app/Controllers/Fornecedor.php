<?php

namespace App\Controllers;

use App\Models\model;
use App\Models\EstadoModel;
use App\Models\CidadeModel;
use App\Models\FornecedorModel;
use CodeIgniter\Controller;

use CodeIgniter\Database\Exceptions\DatabaseException;

class Fornecedor extends BaseController
{
    protected $model;
    protected $estadoModel;
    protected $cidadeModel;

    public function __construct()
    {
        $this->model = new FornecedorModel();
        $this->estadoModel = new EstadoModel();
        $this->cidadeModel = new CidadeModel();
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $data['fornecedores'] = $this->model->getLista();
        return view('restrita/listaFornecedor', $data);
    }

    /**
     * form
     *
     * @param string|null $action
     * @param int|null $id
     * @return string
     */
    public function form(string $action = null, int $id = null)
    {
        $data['action']     = $action;
        $data['data']       = null;
        $data['errors']     = [];

        $data['aEstado']    = $this->estadoModel->orderBy('id', 'ASC')->findAll();

        $data['aCidade']    = $this->cidadeModel->orderBy('id', 'ASC')->findAll();

        if ($action !== 'insert') {
            $data['data']   = $this->model->find($id);
        }

        return view('restrita/formFornecedor', $data);
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
            'nome'              => $post['nome'],
            'cnpj'              => preg_replace('/[^0-9]/', '', $post['cnpj']),
            'endereco'          => $post['endereco'],
            'cidade'            => $post['cidade'],
            'estado'            => $post['estado'],
            'bairro'            => $post['bairro'],
            'numero'            => $post['numero'],
            'telefone'          => preg_replace('/[^0-9]/', '', $post['telefone']),
            'statusRegistro'    => $post['statusRegistro']
        ])) {
            return redirect()->to("/Fornecedor")->with('msgSucess', "Dados atualizados com sucesso.");
        }else {
            return view("restrita/formFornecedor", [
                "action"    => $post['action'],
                'aEstado'   => $this->estadoModel->orderBy('id', 'ASC')->findAll(),
                'aCidade'   => $this->cidadeModel->orderBy('id', 'ASC')->findAll(),
                'data'      => $post,
                'errors'    => $this->model->errors()
            ]);
        }
        
        return redirect()->to(base_url('Fornecedor'));
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
            if ($this->model->delete($id)) {
                session()->setFlashdata('msgSuccess', 'Cargo excluído com sucesso.');
            } else {
                session()->setFlashdata('msgError', 'Falha ao tentar excluir o cargo.');
            }
        } catch (DatabaseException $e) {
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                session()->setFlashdata('msgError', 'Erro: Não é possível excluir este fonecedor, pois ele está relacionado a outros dados.');
            } else {
                session()->setFlashdata('msgError', 'Ocorreu um erro ao tentar excluir o cargo.');
            }
        }

        return redirect()->to(base_url('Fornecedor'));
    }

    /**
     * requireAPI
     *
     * @param string|null $cnpj
     * @return void
     */
    public function requireAPI()
    {

        $segmentos = $this->request->getURI()->getSegments(3);
        
        $cnpj = $segmentos[2] ?? null;

        if ($cnpj) {
            $data = $this->model->requireAPI($cnpj);
            return $this->response->setJSON($data);
        } else {
            return $this->response->setJSON(['error' => 'Parâmetro CNPJ não fornecido na requisição.']);
        }
    }

    /**
     * getCidadeComboBox
     *
     * @param int|null $estadoId
     * @return void
     */
    public function getCidadeComboBox()
    {

        $segmentos = $this->request->getURI()->getSegments(3);

        $estadoId = $segmentos[2] ?? null;

        $cidadeModel = new CidadeModel();

        $dados = $cidadeModel->where('estado', $estadoId)->findAll();
   
        if (empty($dados)) {
            $dados[] = ['id' => ''];
        }

        return $this->response->setJSON($dados);
    }
}
