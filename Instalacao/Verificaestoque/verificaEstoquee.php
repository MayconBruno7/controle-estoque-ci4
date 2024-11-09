<?php

// Conexão com o banco de dados MySQL
use PDO;

$host = 'localhost';
$dbname = 'teste_migration';
$user = 'root';
$password = '';

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
    // Configuração do e-mail do administrador
    global $pdo;
    $config = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'emailAdm'")->fetch(PDO::FETCH_ASSOC);
    $emailAdm = $config['valor'];

    // Adiciona imagem ao corpo do e-mail
    $mensagem .= '<img src="https://www.rosariodalimeira.mg.gov.br/site/images/Brasao/brasao.png" alt="Imagem da empresa" width="100">';
    $corpoEmail = "{$mensagem}<br><br> Esse email é disparado todos os dias com o intuito de notificar sobre o estoque.";

    // Configurações do cabeçalho do e-mail
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: notificacao@seu_dominio.com" . "\r\n";

    // Envia o e-mail
    if (mail($emailAdm, $assunto, $corpoEmail, $headers)) {
        echo "Email enviado com sucesso!";
    } else {
        echo "Erro ao enviar o email.";
    }
}
?>
