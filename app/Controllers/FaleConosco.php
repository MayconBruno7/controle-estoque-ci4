<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FornecedorModel;
use App\Models\ProdutoModel;
use App\Models\ConfiguracoesModel;
use CodeIgniter\HTTP\RedirectResponse;

use CodeIgniter\Email\Email; 
use Config\Email as EmailConfig; 

class FaleConosco extends BaseController 
{

    public $fornecedorModel;
    public $produtoModel;
    public $configuracoesModel;

    /**
     * construct
     */
    public function __construct()
    {
        $this->configuracoesModel   = new ConfiguracoesModel();
        $this->fornecedorModel      = new FornecedorModel();
        $this->produtoModel         = new ProdutoModel();
    }

    /**
     * Exibe o formulário de Fale Conosco.
     *
     * @return string
     */
    public function formularioEmail(): string
    {
        return view('restrita/faleConosco');
    }

    /**
     * Verifica o estoque e envia notificações por e-mail se necessário.
     *
     * @return void
     */
    public function verificaEstoque()
    {

        $dados['aFornecedor'] = $this->fornecedorModel->findAll();
        $dados['aProduto'] = $this->produtoModel->findAll();
        
        $temProdutoAbaixoDoLimite   = false;

        foreach ($dados['aProduto'] as $produto) {
            if ($produto['quantidade'] < 3) {
                $temProdutoAbaixoDoLimite = true;
            }
        }

        if ($temProdutoAbaixoDoLimite) {
            // $this->enviaNotificacaoEstoque($assunto, $message);
            session()->setFlashdata("exibirModalEstoque", true); 
            return redirect()->to(previous_url());

        } else {
            session()->setFlashdata("exibeModalNotificacaoEstoque", true);
            return redirect()->to(previous_url());

        }
    }

   /**
    * Envia um e-mail via formulário de Fale Conosco.
    *
    * @return RedirectResponse
    */
    public function enviarEmail()
    {

        $post = $this->request->getPost();

        if ($post) {
            $emailRemetente     = $this->request->getPost('email', FILTER_VALIDATE_EMAIL);
            $nomeRemetente      = $this->request->getPost('nome');
            $assunto            = $this->request->getPost('assunto');
            $telefone           = $this->request->getPost('telefone');
            $mensagem           = $this->request->getPost('mensagem');

            if (!$emailRemetente) {
                session()->setFlashdata('msgError', 'Email inválido!');
                return redirect()->to('FaleConosco/formularioEmail');
            }

            $corpoEmail = "{$mensagem}<br><br> Para mais informações, ligue pelo telefone: {$telefone} ou envie um email: {$emailRemetente}";

            // Cria uma nova instância da classe Email
            $email          = new Email();
                
            // Cria uma nova instância da classe EmailConfig
            $emailConfig    = new EmailConfig();

            // Inicializa com as configurações
            $email->initialize($emailConfig);
            
            // Configura o destinatário
            $email->setTo('maycon7ads@gmail.com');

            // Configura o assunto e a mensagem
            $email->setSubject($assunto);
            $email->setMessage($corpoEmail);

            // Envia o e-mail e verifica se foi enviado com sucesso
            if ($email->send()) {
                session()->setFlashdata('msgSuccess', 'Email enviado com sucesso.');
            } else {
                session()->setFlashdata('msgError', 'Falha ao tentar enviar o email: ' . $email->printDebugger(['headers']));
            }

            return redirect()->to('FaleConosco/formularioEmail');
        }
    }
}