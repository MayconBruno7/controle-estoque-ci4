<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RelatorioModel;

class Home extends BaseController
{

    public $UsuarioModel;
    public $RelatorioModel;

    /**
     * construct
     */
    public function __construct()
    {
        $this->UsuarioModel     = new UsuarioModel();
        $this->RelatorioModel   = new RelatorioModel();
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {

        // var_dump(session()->get('usuarioNivel'));
        // exit;

        if (!session()->has('usuarioId')) {
            $dados['dados'] = $this->UsuarioModel->findAll();

            return view("usuario/login", $dados);
        } else {
            if (session()->get('usuarioNivel') == 1) {
                return redirect("Home/homeAdmin");
            } else if(session()->get('usuarioNivel') == 11) {
                return redirect("Home/home");
            }
        }

    }

    /**
     * login
     *
     * @return void
     */
    public function login()
    {
        return view("usuario/login");
    }

    /**
     * homeAdmin
     *
     * @return void
     */
    public function homeAdmin()
    {
        
        $DbDados = [];

        $DbDados['aRelatorioDia']       = $this->RelatorioModel->RelatorioDia();
        $DbDados['aRelatorioSemana']    = $this->RelatorioModel->RelatorioSemana();
        $DbDados['aRelatorioMes']       = $this->RelatorioModel->RelatorioMes();
        $DbDados['aRelatorioAno']       = $this->RelatorioModel->RelatorioAno();

        return view(
            "restrita/homeAdmin",
            $DbDados
        );
    }

      /**
     * homeAdmin
     *
     * @return void
     */
    public function home()
    {
        return view("restrita/home");
    }

    /**
	 * Carrega a view Criar nova Conta
	 *
	 * @return void
	 */
	public function criarNovaConta()
	{
		return view("usuario/formCriarConta");
	}

	/**
	 * gravarNovaConta
	 *
	 * @return void
	 */
	public function gravarNovaConta()
	{
		$UsuarioModel = new UsuarioModel();

		$post = $this->request->getPost();

        // var_dump($post);
        // exit("Tamo ai");
		
		// verificar se usuário já tem conta
		$temUsuario = $UsuarioModel->where("email", $post['email'])->first();

		if (is_null($temUsuario)) {

			if (trim($post['senha']) == trim($post['confSenha'])) {

				$created_at = date("Y-m-d H:i:s");
				
				$aUsuario = [
					"nome"				=> $post['nome'],
					"nivel"				=> 11,                   // 11 = Cliente
					"statusRegistro"	=> 2,
					"email"				=> $post['email'],
					"senha"				=> password_hash(trim($post['senha']), PASSWORD_DEFAULT),
				];
		
				if ($this->UsuarioModel->insert($aUsuario) > 0) {
					return redirect("Home/criarNovaConta")->with("msgSucess", "Conta Criada com sucesso");
				} else {
	
					session()->set("msgError", $UsuarioModel->errors());
	
					return view('usuario/formCriarConta', [
						'data'		=> $post,
						'errors' 	=> $UsuarioModel->errors()
					]);
				}
	
			} else {
				session()->setFlashdata("msgError", "Senhas não conferem.");
			} 
			
		} else {
			session()->setFlashdata("msgError", "Usuário já existe na plataforma.");
		}

		return view('usuario/formCriarConta', [
				'data'		=> $post,
				'errors' 	=> []
			]);

	}
}