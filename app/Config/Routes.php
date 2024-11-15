<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('Configuracoes/getInfoEmailAdm', 'Configuracoes::getInfoEmailAdm');
$routes->post('Configuracoes/store', 'Configuracoes::store');

 
 $routes->group('Home', function($routes) {
     $routes->get('index', 'Home::index');
     $routes->get('login', 'Home::login');
     $routes->get('homeAdmin', 'Home::homeAdmin');
     $routes->get('home', 'Home::home');
 
     $routes->get('criarConta', 'Home::criarNovaConta');
     $routes->post('gravarNovaConta', 'Home::gravarNovaConta');
 });

$routes->group('Login', function($routes) {
    $routes->post('signIn', 'Login::signIn');    
    $routes->get('signOut', 'Login::signOut');
    $routes->get('solicitaRecuperacaoSenha', 'Login::solicitaRecuperacaoSenha');
    $routes->post('gerarLinkRecuperaSenha', 'Login::gerarLinkRecuperaSenha');
    $routes->get('recuperarSenha/(:segment)', 'Login::recuperarSenha/$1');
    $routes->post('atualizaRecuperaSenha', 'Login::atualizaRecuperaSenha');
});

$routes->group('Usuario', function($routes) {
    $routes->get("/", 'Usuario::index');
    $routes->get("lista", 'Usuario::index');
    $routes->get("form/(:segment)/(:num)", 'Usuario::form/$1/$2');
    $routes->post("store", 'Usuario::store');
    $routes->post('delete', "Usuario::delete");
    $routes->get("profile/view/(:num)", 'Usuario::profile/view/$1');

    $routes->get("trocaSenha", 'Usuario::trocaSenha');
    $routes->post("atualizaTrocaSenha", 'Usuario::atualizaTrocaSenha');
});


$routes->get('writable/uploads/funcionarios/(:any)', 'FileController::show/$1');

$routes->group('Funcionario', function($routes) {
    $routes->get("/", 'Funcionario::index');
    $routes->get("lista", 'Funcionario::index');
    $routes->get("form/(:segment)/(:num)", 'Funcionario::form/$1/$2');
    $routes->post("store", 'Funcionario::store');
    $routes->post('delete', "Funcionario::delete");

});

$routes->group('Cargo', function($routes) {
    $routes->get("/", 'Cargo::index');
    $routes->get("lista", 'Cargo::index');
    $routes->get("form/(:segment)/(:num)", 'Cargo::form/$1/$2');
    $routes->post("store", 'Cargo::store');
    $routes->post('delete', "Cargo::delete");
});


$routes->group('Relatorio', function($routes) {
    $routes->get("/", 'Relatorio::index');
    $routes->get("relatorioMovimentacoes", 'Relatorio::relatorioMovimentacoes');
    $routes->get("relatorioItensPorFornecedor", 'Relatorio::relatorioItensPorFornecedor');
    $routes->get('getDados/(:any)/(:any)/(:any)/(:any)', 'Relatorio::getDados/$1/$2/$3');
    $routes->get('getDados/(:any)/(:any)/(:any)', 'Relatorio::getDados/$1/$2/$3');


});

$routes->group('Log', function($routes) {
    $routes->get("/", 'Log::index');
    $routes->get('viewLog/view/(:num)', 'Log::viewLog');

});

$routes->group('Produto', function($routes) {
    $routes->get("/", 'Produto::index');
    $routes->get("lista", 'Produto::index');
    $routes->get("form/(:segment)/(:num)", 'Produto::form/$1/$2');
    $routes->post("store", 'Produto::store');
    $routes->post('delete', "Produto::delete");
    $routes->get("index/(:segment)/(:num)/(:num)", 'Produto::index/$1/$2/$3');
    $routes->get('index/(:segment)/(:num)/(:num)/(:num)/(:num)/(:any)', 'Produto::index/$1/$2/$3/$4/$5/$6');

});


$routes->get("HistoricoProdutoMovimentacao/index/(:num)/(:segment)", 'HistoricoProdutoMovimentacao::index/$1/$2');
$routes->get("HistoricoProduto/getHistoricoProduto/(:any)", 'HistoricoProduto::getHistoricoProduto/$1');

$routes->group('Setor', function($routes) {
    $routes->get("/", 'Setor::index');
    $routes->get("lista", 'Setor::index');
    $routes->get("form/(:segment)/(:num)", 'Setor::form/$1/$2');
    $routes->post("store", 'Setor::store');
    $routes->post('delete', "Setor::delete");
});

$routes->group('Fornecedor', function($routes) {
    $routes->get("/", 'Fornecedor::index');
    $routes->get("lista", 'Fornecedor::index');
    $routes->get("form/(:segment)/(:num)", 'Fornecedor::form/$1/$2');
    $routes->post("store", 'Fornecedor::store');
    $routes->post('delete', "Fornecedor::delete");

    $routes->get("getCidadeComboBox(:any)", 'Fornecedor::getCidadeComboBox/$1');
    $routes->get("requireAPI/(:any)", 'Fornecedor::requireAPI/$1');
});

$routes->group('Movimentacao', function($routes) {
    $routes->get("/", 'Movimentacao::index');
    $routes->get("lista", 'Movimentacao::index');
    $routes->get("form/(:segment)/(:num)", 'Movimentacao::form/$1/$2');
    $routes->post("salvarSessao/(:segment)/(:num)", 'Movimentacao::salvarSessao/$1/$2');
    $routes->post("deleteProdutoMovimentacao/(:segment)", 'Movimentacao::deleteProdutoMovimentacao/$1');
    $routes->get("getProdutoComboBox/(:any)", 'Movimentacao::getProdutoComboBox/$1');
    $routes->post("newProdutoMovimentacao/(:segment)", 'Movimentacao::newProdutoMovimentacao/$1');
    $routes->post("update/updateProdutoMovimentacao/(:num)", 'Movimentacao::update/updateProdutoMovimentacao/$1');
    $routes->post("new", 'Movimentacao::new');
    $routes->post("update", 'Movimentacao::update');
    $routes->get('form/(:segment)/(:num)/Home', 'Movimentacao::form/$1/$2');
    $routes->post("store", 'Movimentacao::store');
    $routes->post('delete', "Movimentacao::delete");
});

$routes->get('sobreNos', 'sobreNos::index');

$routes->group('FaleConosco', function($routes) {
    $routes->get("formularioEmail", 'FaleConosco::formularioEmail');
    $routes->post("enviarEmail", 'FaleConosco::enviarEmail');
    $routes->get('verificaEstoque', 'FaleConosco::verificaEstoque');

});