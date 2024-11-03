<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\FuncionarioModel;
use App\Models\UsuarioRecuperaSenhaModel;

use CodeIgniter\HTTP\RedirectResponse;

use CodeIgniter\Email\Email; 
use Config\Email as EmailConfig; 

class Login extends BaseController 
{
    protected $usuarioModel;
    protected $usuarioRecuperaSenhaModel;
    protected $funcionarioModel;

    public function __construct()
    {
        $this->usuarioModel                 = new UsuarioModel();
        $this->usuarioRecuperaSenhaModel    = new UsuarioRecuperaSenhaModel();
        $this->funcionarioModel             = new FuncionarioModel();
    }

    public function signIn() 
    {
		$post 		= $this->request->getPost();
		$login 		= $post['email'];
		$password 	= $post['senha'];

		$UsuarioModel = new UsuarioModel();

		// buscar o usuário na base de dados

		$dadosUsuario = $UsuarioModel->getByEmail(trim($login));

		if (is_null($dadosUsuario)) {

			// Verifica se existe usuários criados na base de dados

			if (count($UsuarioModel->findAll()) == 0) {
                if ($UsuarioModel->insertDadosSuperUser() > 0) {
					return redirect()->back()->with("msgSucess", "Super usuário criado com sucesso, favor efetar novamente o login")->withInput();
                } else {
					return redirect()->back()->with("msgError", "Falha na criação do Super usuário.")->withInput();
                }
			}
		}

		if (!is_null($dadosUsuario)) {

			// Verifica o status do usuário

			if ($dadosUsuario['statusRegistro'] == 1) {

				//	Verifica a senha do usuário
				if (password_verify(trim($password), $dadosUsuario['senha'])) {

					// Sessões de controle do usuário
					if (isset($post['remember'])) {
						$tempoPdraoLogin = 864000;	// 10 Dias
					} else {
						$tempoPdraoLogin = 3600;	// 1 Hora
					}

					session()->setTempdata('isLoggedIn', true, $tempoPdraoLogin);
					session()->setTempdata('usuarioId', $dadosUsuario['id'], $tempoPdraoLogin);
					session()->setTempdata('usuarioLogin', $dadosUsuario['nome'], $tempoPdraoLogin);
					session()->setTempdata('usuarioEmail', $dadosUsuario['email'], $tempoPdraoLogin);
					session()->setTempdata('usuarioNivel', $dadosUsuario['nivel'], $tempoPdraoLogin);
					session()->setTempdata('id_funcionario', $dadosUsuario['id_funcionario'], $tempoPdraoLogin);
					session()->setTempdata('current_user', $dadosUsuario['id'], $tempoPdraoLogin);

					// 

					// Recuperar imagem do funcionário
                    $funcionario = $this->funcionarioModel->recuperaFuncionario($dadosUsuario['id_funcionario']);

                    // Verifica se $funcionario é um array e não está vazio
                    if (!empty($funcionario) && isset($funcionario['imagem'])) {
                        session()->set('usuarioImagem', $funcionario['imagem']);
                    } else {
                        // Trate o caso em que não há funcionário ou imagem disponível
                        session()->set('usuarioImagem', 'person.svg'); // Substitua pelo caminho da imagem padrão, se necessário
                    }
        
                    // Gerenciamento de cookies
                    if (isset($_COOKIE['username']) && $_COOKIE['username'] !== $post["email"]) {
                        setcookie('username', '', time() - 3600, "/");
                        setcookie('password', '', time() - 3600, "/");
                    }
        
                    if (isset($post['remember'])) {
                        // Se "Lembrar-me" estiver marcado, cria os cookies com duração de 30 dias
                        setcookie('username', $post["email"], time() + (86400 * 30), "/");
                        setcookie('password', $post["senha"], time() + (86400 * 30), "/");
                    } else {
                        // Se "Lembrar-me" não estiver marcado, expira os cookies definindo tempo no passado
                        setcookie('username', '', time() - 3600, "/");
                        setcookie('password', '', time() - 3600, "/");
                    }
                    
                    if (session()->get('usuarioNivel') == 1) {
                        $redirectUrl = 'Home/homeAdmin';
                    } elseif (session()->get('usuarioNivel') == 11) {
                        $redirectUrl = 'Home/home';
                    } 

                    return redirect()->to(base_url($redirectUrl));
					//
					
				} else {
					return redirect()->back()->with("msgError", "Usuário ou Senha incorretos.")->withInput();
				}
			
			} else {
				return redirect()->back()->with("msgError", "Usuário BLOQUEADO/INATIVO, acesso indisponível.")->withInput();
			}

		} else {
			return redirect()->back()->with("msgError", "Usuário ou Senha incorretos.")->withInput();
		}
    }


    public function signOut()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }

    public function solicitaRecuperacaoSenha()
    {
        return view('usuario/formSolicitaRecuperacaoSenha');
    }

    public function gerarLinkRecuperaSenha()
    {
        $post = $this->request->getPost();
        $usuario = $this->usuarioModel->getByEmail($post['email']);

        if (!$usuario) {
            return redirect()->to(base_url('Login/solicitaRecuperacaoSenha'))->with('msgError', 'E-mail não encontrado.');
        }

        $created_at = date('Y-m-d H:i:s');
        $chave = sha1($usuario['id'] . $usuario['senha'] . date('YmdHis', strtotime($created_at)));
        $link = base_url('Login/recuperarSenha/' . $chave);

        $corpoEmail = 'Clique no link para recuperar sua senha: <a href="'. $link .'">Recuperar a senha</a>';

        // Cria uma nova instância da classe Email
        $email          = new Email();
    
        // Cria uma nova instância da classe EmailConfig
        $emailConfig    = new EmailConfig();
    
        // Inicializa com as configurações
        $email->initialize($emailConfig);
    
        // Configura o remetente
        $email->setFrom($emailConfig->fromEmail, $emailConfig->fromName);
    
        // Configura o destinatário
        $email->setTo($usuario['email']); // Enviar para o email do administrador
    
        // Configura o assunto e a mensagem
        $email->setSubject('Recuperação de Senha');
        $email->setMessage($corpoEmail);

        // $enviado = Email::enviaEmail('noreply@exemplo.com', 'Recuperação de Senha', 'Recuperação de Senha', $corpoEmail, $usuario['email']);

        if ($email->send()) {
            $usuarioRecuperaSenhaModel = new UsuarioRecuperaSenhaModel();
            $usuarioRecuperaSenhaModel->desativaChaveAntigas($usuario['id']);
            $usuarioRecuperaSenhaModel->insert(['usuario_id' => $usuario['id'], 'chave' => $chave, 'created_at' => $created_at]);

            return redirect()->to(base_url('Home/login'))->with('msgSuccess', 'Link de recuperação enviado!');
        }

        return redirect()->to(base_url('login/solicitaRecuperacaoSenha'))->with('msgError', 'Falha ao enviar o e-mail.');
    }

    public function recuperarSenha($chave)
    {
        $usuarioRecuperaSenhaModel = new UsuarioRecuperaSenhaModel();
        $userChave = $usuarioRecuperaSenhaModel->getRecuperaSenhaChave($chave);

        if ($userChave) {
            $validade = strtotime("+1 hour", strtotime($userChave['created_at']));
            if (time() <= $validade) {
                $usuario = $this->usuarioModel->find($userChave['usuario_id']);
                if ($usuario && sha1($userChave['usuario_id'] . $usuario['senha'] . date('YmdHis', strtotime($userChave['created_at']))) === $chave) {
                    // session()->set('recuperaSenha', ['usuario_id' => $usuario['id']]);
                    $usuario['usuariorecuperasenha_id'] = $userChave['id'];
                    return view('usuario/formRecuperarSenha', ['usuario' => $usuario]);
                }
            }
        }
        return redirect()->to(base_url('login/solicitaRecuperacaoSenha'))->with('msgError', 'Chave inválida ou expirada.');
    }

    public function atualizaRecuperaSenha()
    {
        $post = $this->request->getPost();

        if ($post['NovaSenha'] !== $post['NovaSenha2']) {
            return redirect()->back()->with('msgError', 'Senhas não conferem.');
        }

        $usuarioRecuperaSenhaModel = new UsuarioRecuperaSenhaModel();
        $usuario = $this->usuarioModel->find($post['id']);
        if ($usuario) {
            $usuarioRecuperaSenhaModel->update($post['usuariorecuperasenha_id'], ['statusRegistro' => 2]);
            $this->usuarioModel->update($usuario['id'], ['senha' => password_hash($post['NovaSenha'], PASSWORD_DEFAULT)]);
            return redirect()->to(base_url('Home/login'))->with('msgSuccess', 'Senha alterada com sucesso!');
        }

        return redirect()->back()->with('msgError', 'Falha ao atualizar senha.');
    }
}
