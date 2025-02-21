<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\FuncionarioModel;
use App\Models\CargoModel;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Usuario extends BaseController
{
    protected $model;
    public $FuncionarioModel;
    public $CargoModel;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->model            = new UsuarioModel();
        $this->FuncionarioModel = new FuncionarioModel();
        $this->CargoModel       = new CargoModel();

    }

    /**
     * lista
     *
     * @return void
     */
    public function index()
    {

        $data['usuarios'] = $this->model->getLista();
        return view('usuario/listaUsuario', $data);
    }

    /**
     * form
     *
     * @return void
     */
    public function form($action, $id = null)
    {

        $data['data'] = null;

        if ($action != "new" && $id !== null) {
            $data['data'] = $this->model->find($id);
        }

        $data['action'] = $action;
        $data['errors'] = [];

        $data['aFuncionario'] =  $this->FuncionarioModel->getLista();

        return view('usuario/formUsuario', $data);
    }

    /**
     * store
     *
     * @return void
    */
    public function store()
    {

        $post       = $this->request->getPost();

        $senha      = isset($post['senha']) ? $post['senha'] : '';
        $confSenha  = isset($post['confSenha']) ? $post['confSenha'] : '';
        
        $action     = isset($post['action']) ? $post['action'] : '';


        if($senha === $confSenha) {
            if (empty($senha)) {
                if (isset($post['id'])) {
                    $usuario = $this->model->find($post['id']);
                    $senhaCriptografada = $usuario['senha'];
                }
                
            } else {
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
            }

            if ($this->model->save([
                'id'                => ($post['id'] == "" ? null : $post['id']),
                "nivel"             => $post['nivel'],
                "statusRegistro"    => $post['statusRegistro'],
                "nome"              => $post['nome'],
                "senha"             => $senhaCriptografada,
                "email"             => $post['email'],
                "id_funcionario"    => !empty($post['funcionarios']) ? $post['funcionarios'] : null
            ])) { 
                return redirect()->to("/Usuario")->with('msgSuccess', "Dados inseridos com sucesso!");
            } else {
                return view("usuario/listaUsuario", [
                    "action"    => $action,
                    'data'      => $post,
                    'errors'    => $this->model->errors()
                ]);
            }
        } else {
            return view("usuario/formUsuario", [
                "action"        => $action,
                'data'          => ['id_funcionario' => $post['funcionarios'], $post],
                'aFuncionario'  => $this->FuncionarioModel->getLista(),
                'errors'        => ['senha' => 'Senha não confere com o confere Senha!', 'confSenha' => 'Confere Senha não confere com a senha!']
            ]);
        }
    }

    public function profile()
    {
        $data = [];
   
        $segmentos      = $this->request->getURI()->getSegments(3);
        $id           = $segmentos[3]  ?? null;

        $data['aUsuario']       = $this->model->find($id);

        $data['aFuncionario']   = $this->FuncionarioModel->recuperaFuncionario(session()->get('id_funcionario'));

        $data['aCargo']         = $this->CargoModel->getLista();

        if ($data['aUsuario']['id_funcionario'] != null) {
            return view('usuario/profile', $data);
        } else {
            session()->setFlashdata('msgError', 'Nenhum funcionario relacionado ao usuário');
            return redirect()->to(previous_url());
        } 
    }

    /**
     * delete - Exclui um usuário no banco de dados
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();

        try {
            if ($this->model->delete($post['id'])) {
                session()->setFlashdata('msgSuccess', 'usuário excluído com sucesso.');
            } else {
                session()->setFlashdata('msgError', 'Falha ao tentar excluir o usuário.');
            }
        } catch (DatabaseException $e) {
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                session()->setFlashdata('msgError', 'Erro: Não é possível excluir este usuário, pois ele está relacionado a outros dados.');
            } else {
                session()->setFlashdata('msgError', 'Ocorreu um erro ao tentar excluir o usuário.');
            }
        }

        return redirect()->to(base_url('Usuario'));
    }

    /**
     * trocaSenha - Chama a view Trocar a senha
     *
     * @return void
     */
    public function trocaSenha()
    {
        return view("usuario/formTrocaSenha");
    }

    /**
     * atualizaSenha - Atualiza a senha do usuário
     *
     * @return void
     */
    public function atualizaTrocaSenha() 
    {
        $post = $this->request->getPost();
        $userAtual = $this->model->find($post["id"]);

        if ($userAtual) {
            if (password_verify(trim($post["senhaAtual"]), $userAtual['senha'])) {
                if (trim($post["novaSenha"]) == trim($post["novaSenha2"])) {
                    $lUpdate = $this->model->update($post['id'], ['senha' => password_hash($post["novaSenha"], PASSWORD_DEFAULT)]);

                    if ($lUpdate) {
                        session()->setFlashdata("msgSuccess", "Senha alterada com sucesso");
                        return redirect("Usuario/trocaSenha");  
                    } else {
                        session()->setFlashdata("msgError", "Falha na atualização da nova senha!");
                        return redirect("Usuario/trocaSenha");    
                    }
                } else {
                    session()->setFlashdata("msgError", "Nova senha e conferência da senha estão divergentes!");
                    return redirect("Usuario/trocaSenha");                  
                }
            } else {
                session()->setFlashdata("msgError", "Senha atual informada não confere!");
                return redirect("Usuario/trocaSenha");               
            }
        } else {
            session()->setFlashdata("msgError", "Usuário inválido!");
            return redirect("Usuario/trocaSenha");   
        }
    }
}
