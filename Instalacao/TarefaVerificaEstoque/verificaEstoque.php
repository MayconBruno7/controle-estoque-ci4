<?php

// Incluir o autoload do Composer para carregar as classes do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$host = 'localhost';
$dbname = 'teste_migration';
$user = 'maycon';
$password = 'Minha_senha7';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Função para obter o nome do fornecedor
function getFornecedorNome($fornecedorId, $fornecedores) {
    foreach ($fornecedores as $fornecedor) {
        if ($fornecedor['id'] == $fornecedorId) {
            return $fornecedor['nome'];
        }
    }
    return 'Desconhecido';
}

// Busca fornecedores e produtos
$fornecedores = $pdo->query("SELECT * FROM fornecedor")->fetchAll(PDO::FETCH_ASSOC);
$produtos = $pdo->query("SELECT * FROM produto")->fetchAll(PDO::FETCH_ASSOC);

$assunto = 'Alerta de estoque';
$mensagem = "Os seguintes produtos estão com o estoque abaixo do limite de alerta:<br><br>";
$temProdutoAbaixoDoLimite = false;

foreach ($produtos as $produto) {
    if ($produto['quantidade'] < 3) {
        $fornecedorNome = getFornecedorNome($produto['fornecedor'], $fornecedores);
        $mensagem .= "Nome: {$produto['nome']}<br>";
        $mensagem .= "Quantidade: {$produto['quantidade']}<br>";
        $mensagem .= "Fornecedor: {$fornecedorNome}<br><br>";
        $temProdutoAbaixoDoLimite = true;
    }
}

// Envio de e-mail se houver produtos com estoque baixo
if ($temProdutoAbaixoDoLimite) {
    enviaNotificacaoEstoque($assunto, $mensagem);
} else {
    echo "Estoque está dentro dos limites.";
}

// Função para enviar notificação por e-mail
function enviaNotificacaoEstoque($assunto, $mensagem) {
    global $pdo;
    // Configuração do e-mail do administrador
    $config = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'emailAdm'")->fetch(PDO::FETCH_ASSOC);
    $emailAdm = $config['valor'];

    // Adiciona imagem ao corpo do e-mail
    $mensagem .= '<img src="https://www.rosariodalimeira.mg.gov.br/site/images/Brasao/brasao.png" alt="Imagem da empresa" width="100">';
    $corpoEmail = "{$mensagem}<br><br> Esse email é disparado todos os dias com o intuito de notificar sobre o estoque.";

    // Criando uma instância do PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'maycon7ads@gmail.com'; // Substitua com seu e-mail
        $mail->Password = 'wqml dmnx prke gavm';       // Substitua com sua senha
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatário e remetente
        $mail->setFrom('no-reply@controleestoque.com', 'no-reply-estoque');
        $mail->addAddress($emailAdm);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = $corpoEmail;

        // Envia o e-mail
        $mail->send();
        echo "Email enviado com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
