<?php

namespace App\Controllers;

use App\Models\ConfiguracoesModel;

class Configuracoes extends BaseController
{
    public $model;

    /**
     * construct
     */
    public function __construct()
    {
        $this->model = new ConfiguracoesModel();
    }

    /**
     * getInfoEmail
     *
     * @return void
     */
    public function getInfoEmailAdm()
    {
        $data = $this->model->getAdmEmail();

        // Retorna a resposta como JSON
        return $this->response->setJSON($data);
    }

    public function store()
    {

        $dadosConfig = $this->model->findAll();

        $post = $this->request->getPost();

        if ($dadosConfig) {
            
            $data = [
                'id'        => (int)$post['id'] ?? null,
                'valor'     => $post['email'] ?? null,
                'descricao' => $post['descricao'] ?? null,
            ];

            if ($this->model->update((int)$post['id'], $data)) {
                session()->setFlashdata('sucessoUsuarioAdm', 'Operação realizada com sucesso!');
            } else {
                session()->setFlashdata('erroUsuarioAdm', 'Erro ao realizar operação, contate o suporte técnico!');        
            }

            // Redireciona o usuário para a página anterior
            return redirect()->to(previous_url());
           
        } else {

            $data = [
                'valor'     => $post['email'] ?? null,
                'chave'     => 'emailAdm',
                'descricao' => 'Email em que será enviado as notificações de estoque!',
            ];
    
            if ($this->model->insert($data)) {
                session()->setFlashdata('sucessoUsuarioAdm', 'Operação realizada com sucesso!');
            } else {
                session()->setFlashdata('erroUsuarioAdm', 'Erro ao realizar operação, contate o suporte técnico!');
            }
            
            // Redireciona o usuário para a página anterior
            return redirect()->to(previous_url());  
        }
    }
}