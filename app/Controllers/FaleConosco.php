<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FornecedorModel;
use App\Models\ProdutoModel;
use App\Models\ConfiguracoesModel;
use CodeIgniter\HTTP\RedirectResponse;

use CodeIgniter\Email\Email; // Importa a classe de Email
use Config\Email as EmailConfig; // Corrigido para importar a configuração de Email

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
        
        $assunto                    = 'Alerta de estoque';
        $message                    = "Os seguintes produtos estão com o estoque abaixo do limite de alerta:<br><br>";
        $temProdutoAbaixoDoLimite   = false;

        foreach ($dados['aProduto'] as $produto) {
            if ($produto['quantidade'] < 3) {
                $fornecedorNome = $this->getFornecedorNome($produto['fornecedor'], $dados['aFornecedor']);
                $message .= "Nome: {$produto['nome']}<br>";
                $message .= "Quantidade: {$produto['quantidade']}<br>";
                $message .= "Fornecedor: {$fornecedorNome}<br><br>";
                $temProdutoAbaixoDoLimite = true;
            }
        }

        if ($temProdutoAbaixoDoLimite) {
            $this->enviaNotificacaoEstoque($assunto, $message);
            return redirect()->to(previous_url());

        } else {
            session()->setFlashdata("exibeModalNotificacaoEstoque", true);
            return redirect()->to(previous_url());

        }
    }

    /**
     * Envia uma notificação por e-mail sobre o estoque.
     *
     * @param string $emailRemetente
     * @param string $nomeRemetente
     * @param string $assunto
     * @param string $mensagem
     * 
    */
    private function enviaNotificacaoEstoque(string $assunto, string $mensagem)
    {

        $usuarioAdministradorEmail  = $this->configuracoesModel->where('chave', 'emailAdm')->first();

        $imagemBase64 = 'imagemempresa';
        $mensagem       .= '<img alt="imagem" src="' . $imagemBase64 . '" />';
    
        $corpoEmail     = "{$mensagem}<br><br> Esse email é disparado todos os dias com o intuito de notificar sobre o estoque.";
    
        $email          = new Email();
        $emailConfig    = new EmailConfig();
        $email->initialize($emailConfig);
        $email->setFrom($emailConfig->fromEmail, $emailConfig->fromName);
        $email->setTo($usuarioAdministradorEmail['valor']); 
        $email->setSubject($assunto);
        $email->setMessage($corpoEmail);
    
        if ($email->send()) {
        session()->setFlashdata('msgSuccess', 'Email enviado com sucesso!');
        } else {
            session()->setFlashdata('msgError', 'Erro ao enviar email: ' . $email->printDebugger(['headers']));
        }

        session()->setFlashdata("exibirModalEstoque", true);
    }
    

   /**
    * Obtém o nome do fornecedor pelo ID.
    *
    * @param int $fornecedorId
    * @param array $fornecedores
    * @return string
    */
   private function getFornecedorNome(int $fornecedorId, array $fornecedores): string
   {
       foreach ($fornecedores as $fornecedor) {
           if ($fornecedor['id'] == $fornecedorId) {
               return $fornecedor['nome'];
           }
       }
       return '';
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

            $email          = new Email();
            $emailConfig    = new EmailConfig();
            $email->initialize($emailConfig);
            $email->setTo('maycon7ads@gmail.com');

            $email->setSubject($assunto);
            $email->setMessage($corpoEmail);

            if ($email->send()) {
                session()->setFlashdata('msgSuccess', 'Email enviado com sucesso.');
            } else {
                session()->setFlashdata('msgError', 'Falha ao tentar enviar o email: ' . $email->printDebugger(['headers']));
            }

            return redirect()->to('FaleConosco/formularioEmail');
        }
    }
}