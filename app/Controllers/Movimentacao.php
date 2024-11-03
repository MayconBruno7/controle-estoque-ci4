<?php

namespace App\Controllers;

use App\Models\model;
use App\Models\MovimentacaoItemModel;
use App\Models\SetorModel;
use App\Models\FornecedorModel;
use App\Models\MovimentacaoModel;
use App\Models\ProdutoModel;

class Movimentacao extends BaseController
{
    protected $model;
    protected $movimentacaoItemModel;
    protected $setorModel;
    protected $fornecedorModel;
    protected $produtoModel;


    public function __construct()
    {
        // Injeção de dependência dos modelos
        $this->model                    = new MovimentacaoModel();
        $this->movimentacaoItemModel    = new MovimentacaoItemModel();
        $this->setorModel               = new SetorModel();
        $this->fornecedorModel          = new FornecedorModel();
        $this->produtoModel             = new ProdutoModel();

        // Redirecionar se o usuário não estiver logado
        if (!$this->getUsuario()) {
            return redirect()->to('Home');
        }
    }

    public function index()
    {
        $data['movimentacoes'] = $this->model->getLista();
        return view('restrita/listaMovimentacao', $data);
    }

    public function form($action, $id = null)
    {
        $data['action'] = $action;
        $data['data']   = null;
        $data['errors'] = [];

        if ($action != "new" && $id !== null) {
            $data['aItemMovimentacao']  = $this->movimentacaoItemModel->listaProdutos($id);
            $data['data']               = $this->model->find($id);
        }

        $data['aSetor'] = $this->setorModel->findAll();
        $data['aFornecedor'] = $this->fornecedorModel->findAll();
        $data['aProduto'] = $this->produtoModel->findAll();

        return view('restrita/formMovimentacao', $data);
    }

    /**
     * salvarSessao function
     *
     * @return void
     */
    public function salvarSessao()
    {

        // Receber dados em JSON da requisição
        $movimentacao = $this->request->getJSON(); // Get JSON enviado pelo cliente

        // Verificar se os dados foram recebidos
        if ($movimentacao) {

            session()->set('movimentacao', [
                'fornecedor_id'     => $movimentacao->fornecedor_id,
                'tipo_movimentacao' => $movimentacao->tipo_movimentacao,
                'statusRegistro'    => $movimentacao->statusRegistro,
                'setor_id'          => $movimentacao->setor_id,
                'data_pedido'       => $movimentacao->data_pedido,
                'data_chegada'      => $movimentacao->data_chegada,
                'motivo'            => $movimentacao->motivo,
                'produtos'          => $movimentacao->produtos // Atualiza apenas a parte dos produtos
            ]);

            // Retornar uma resposta JSON de sucesso
            return $this->response->setJSON([
                // Salva os dados na sessão
                'status'    => 'success',
                'message'   => 'Movimentação salva com sucesso'
            ]);

        } else {
            // Caso os dados não tenham sido enviados corretamente, retorna um erro
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Dados inválidos ou não enviados corretamente'
            ]);
        }
    }

    /**
     * new function
     *
     * @return void
     */
    public function new()
    {
        $post = $this->request->getPost(); // Obtendo dados do POST

        // Verifica se todos os campos necessários do formulário foram enviados
        if (isset($post['fornecedor_id'],
            $post['tipo'],
            $post['statusRegistro'],
            $post['setor_id'],
            $post['data_pedido'],
            $post['motivo']))
        {

            // Dados da movimentação
            $fornecedor_id      = (int)$post['fornecedor_id'];
            $setor_id           = (int)$post['setor_id'];
            $data_pedido        = $post['data_pedido'];
            $data_chegada       = $post['data_chegada'];
            $motivo             = $post['motivo'];
            $statusRegistro     = (int)$post['statusRegistro'];
            $tipo_movimentacao  = (int)$post['tipo'];

            // Dados do produto
            $quantidade     = isset($post['quantidade']) ? (int)$post['quantidade'] : '';
            $id_produto     = isset($post['id_produto']) ? (int)$post['id_produto'] : '';
            $valor_produto  = isset($post['valor']) ? (float)$post['valor'] : '';

            // Carregar o model de Produto
            $ProdutoModel   = new ProdutoModel(); // Não precisamos mais de `loadModel()`
            $dadosProduto   = $ProdutoModel->recuperaProduto($id_produto);

            // Recuperando todos os segmentos da URL
            $segmentos      = $this->request->getURI()->getSegments(3);

            // Acessando o primeiro segmento
            $action         = $segmentos[1] ?? null;

            // Se estamos em modo de atualização
            if ($action == 'update') {
                // Verificar se a sessão de movimentação existe
                $session = session();
                if (!$session->has('movimentacao')) {
                    $session->set('movimentacao', ['produtos' => []]);
                }

                $movimentacao = $session->get('movimentacao');
                $produtos = isset($movimentacao['produtos']) ? $movimentacao['produtos'] : [];

                // Verificar se o produto já está na sessão de movimentação
                $produtoEncontrado = false;
                foreach ($produtos as &$produto_sessao) {
                    if ($produto_sessao['id_produto'] == $id_produto) {
                        // Atualiza a quantidade do produto na sessão
                        $produto_sessao['quantidade']   += $quantidade;
                        $produto_sessao['valor']        = $valor_produto;
                        $produtoEncontrado = true;
                        break;
                    }
                }

                // Caso o produto não tenha sido encontrado, adiciona-o à sessão
                if (!$produtoEncontrado) {

                    $produtos[] = [
                        'id_produto' => $id_produto,
                        'quantidade' => $quantidade,
                        'valor' => $valor_produto
                    ];
                }

                // Atualiza a sessão com os produtos modificados
                $movimentacao['produtos'] = $produtos;
                $session->set('movimentacao', $movimentacao);
            }

            // Verificação de estoque
            $estoqueNegativo = false;

            if (isset($id_produto) && $id_produto !== '') {
                if ($tipo_movimentacao == '2') {
                    // Verifica se há dados do produto e se a quantidade é suficiente para saída
                    $estoqueNegativo = ($dadosProduto !== null && $dadosProduto['quantidade'] < $quantidade);
                } elseif ($tipo_movimentacao == '2' || $dadosProduto === null) {
                    // Movimentação de entrada ou produto não encontrado
                    $estoqueNegativo = false;
                }
            }

            // Se a verificação de estoque for bem-sucedida
            if (!$estoqueNegativo) {

                // Inicializar um array para armazenar os produtos formatados
                $produtosArray = [];

                // Verificar se há produtos na movimentação e iterar sobre eles
                if ( session()->has('movimentacao') && is_array(session()->get('movimentacao'))) {
                    foreach (session()->get('movimentacao')['produtos'] as $produto) {
                        $produtosArray[] = [
                            'id_produtos' => $produto['id_produto'],
                            'quantidade'  => $produto['quantidade'],
                            'valor'       => $produto['valor']
                        ];
                    }
                }
                
                // Inserir movimentação e produtos
                $inserir = $this->model->insertMovimentacao([
                    'id_fornecedor'    => $fornecedor_id,
                    'tipo'             => $tipo_movimentacao,
                    'statusRegistro'   => $statusRegistro,
                    'id_setor'         => $setor_id,
                    'data_pedido'      => $data_pedido,
                    'data_chegada'     => $data_chegada,
                    'motivo'           => $motivo
                ], 
                    $produtosArray
                );
                
                if($inserir) {
                    // Limpa a sessão e redireciona
                    session()->has('prod_mov_atualizado') ? session()->set('prod_mov_atualizado', false) : "";
                    session()->has('movimentacao') ? session()->remove('movimentacao') : "";
                    session()->has('produtos') ? session()->remove('produtos') : "";
                    return redirect()->to("/Movimentacao")->with('msgSuccess', 'Movimentação adicionada com sucesso.');

                }
            } else {
                return redirect()->to("/Movimentacao/form/new/0")->with('msgError', 'Quantidade da movimentação de saída maior que a do produto em estoque.');
            }
        } else {
            return redirect()->to("/Movimentacao/form/new/0")->with('msgError', 'Dados do formulário insuficientes.');
        }
    }

    /**
     * newProdutoMovimentacao function
     *
     * @return void
     */
    public function newProdutoMovimentacao()
    {
        $post = $this->request->getPost();

        // Obtenha os dados do produto do POST
        $id_movimentacao    = isset($post['id_movimentacoes']) ? (int)$post['id_movimentacoes'] : "";
        $quantidade         = (int)$post['quantidade'];
        $id_produto         = (int)$post['id_produto'];
        $valor_produto      = (float)$post['valor'];

        $produtoEncontrado  = false;

        // Recuperar produto e garantir que o resultado seja um array
        $dadosProduto['aProduto'] = (array) $this->produtoModel->recuperaProduto($id_produto);

        // Verificar se há uma sessão de movimentação
        if (!session()->has('movimentacao')) {
            // Inicializa a movimentação com um array vazio para produtos
            session()->set('movimentacao', [
                'produtos' => [] // Corrigido para garantir que seja um array
            ]);
        }

        // Obter produtos da sessão e garantir que seja um array
        $movimentacao = session()->get('movimentacao');
        $produtos = isset($movimentacao['produtos']) ? (array) $movimentacao['produtos'] : [];

        // Acesse os produtos e verifique se o produto já está na sessão
        foreach ($produtos as &$produto_sessao) {
            // Se o produto na sessão for um objeto, converta para array
            if (is_object($produto_sessao)) {
                $produto_sessao = (array) $produto_sessao;
            }

            if (isset($produto_sessao['id_produto']) && $produto_sessao['id_produto'] == $id_produto) {
                $produtoEncontrado = true;

                // Converter a quantidade para um inteiro para evitar problemas com strings
                $quantidadeAtual    = (int)$produto_sessao['quantidade'];
                $quantidadeNova     = $quantidadeAtual + $quantidade;

                // Atualizar a quantidade do produto na sessão
                $produto_sessao['quantidade']   = $quantidadeNova;
                $produto_sessao['valor']        = $valor_produto;

                break; // Saia do loop se o produto foi encontrado e atualizado
            }
        }

        // Se o produto não estiver na sessão de movimentação, adicioná-lo
        if (!$produtoEncontrado) {
            // Adiciona o novo produto ao array de produtos
            $produtos[] = [
                'nome_produto' => $dadosProduto['aProduto']['nome'],
                'id_produto' => $id_produto,
                'quantidade' => $quantidade,
                'valor' => $valor_produto
            ];
        }

        // Atualiza a sessão mantendo as outras informações da movimentação
        $movimentacaoAtual = session()->get('movimentacao'); // Obtém a movimentação atual
        $movimentacaoAtual['produtos'] = $produtos; // Atualiza apenas a parte dos produtos

        session()->set('movimentacao', $movimentacaoAtual); // Atualiza a sessão com todas as informações
        return redirect()->to('/Movimentacao/form/new/0')->with('msgSuccess', 'Produto adicionado à movimentação.');

    }

    /**
     * deleteProdutoMovimentacao function
     *
     * @return void
     */
    public function deleteProdutoMovimentacao()
    {
        $post = $this->request->getPost();

        $id_movimentacao    = isset($post['id_movimentacao']) ? (int)$post['id_movimentacao'] : "";
        $quantidadeRemover  = (int)$post['quantidadeRemover'];
        $id_produto         = (int)$post['id_produto'];
        $tipo_movimentacao  = (int)$post['tipo'];
        $valor              = (int)$post['valor'];
    
        // Recuperando todos os segmentos da URL
        $segmentos  = service('request')->getURI()->getSegments();
        $action     = $segmentos[2] ?? null;
    
        $produtoEncontrado = false;
     
        // Verifica se a sessão de movimentação e os produtos estão definidos
        if (session()->has('movimentacao') && isset(session('movimentacao')['produtos']) && $action === 'delete') {
            
            // Obtém a lista completa de produtos da sessão
            $produtosSessao = (array)session('movimentacao')['produtos'];
    
            // Percorre os produtos na sessão de movimentação
            foreach ($produtosSessao as $key => &$produto_sessao) { // Usando referência (&)

                if (is_object($produto_sessao)) {
                    $produto_sessao = (array)$produto_sessao;
                }
    
                if ($produto_sessao['id_produto'] == $id_produto) {
                    // Verifica se a quantidade a ser removida é válida
                    if ($quantidadeRemover <= 0) {
                        return redirect()->to('/Movimentacao/form/new/0')->with('msgError', "Quantidade a ser removida deve ser maior que zero.");
                    }
    
                    // Atualiza a quantidade do produto na sessão
                    $produto_sessao['quantidade'] -= $quantidadeRemover;
    
                    // Se a quantidade for menor ou igual a zero, remove o produto da sessão
                    if ($produto_sessao['quantidade'] <= 0) {
                        unset($produtosSessao[$key]); // Remove o produto da lista
                    }
    
                    $produtoEncontrado = true;
    
                    break; // Produto encontrado e atualizado, pode sair do loop
                }
            }
    
            // Se o produto foi encontrado e atualizado na lista de produtos
            if ($produtoEncontrado) {
                // Atualiza a sessão mantendo todas as informações da movimentação
                $movimentacaoAtual              = session()->get('movimentacao');
                $movimentacaoAtual['produtos']  = $produtosSessao; // Atualiza a lista de produtos completa
    
                session()->set('movimentacao', $movimentacaoAtual); // Atualiza a sessão com todas as informações
                session()->has('prod_mov_atualizado') ? session()->set('prod_mov_atualizado', true) : "";
    
                return redirect()->to('/Movimentacao/form/new/0')->with('msgSuccess', "Produto excluído da movimentação.");
            }
        }
    
        // Caso o produto não seja encontrado na sessão, verifique no banco de dados
        if (!session()->has('movimentacao') && $action == 'delete') {
            $dadosProduto = (array)$this->produtoModel->recuperaProduto($id_produto);

            $dadosProduto['valor'] = $valor; 
    
            $deletaProduto = $this->model->deleteInfoProdutoMovimentacao($id_movimentacao, $dadosProduto, $tipo_movimentacao, $quantidadeRemover);
    
            if ($deletaProduto) {
                session()->has('prod_mov_atualizado') ? session()->set('prod_mov_atualizado', true) : "";
                return redirect()->to('/Movimentacao/form/update/' . $id_movimentacao)->with('msgSuccess', "Item deletado da movimentação.");
            }
        }
    
        return redirect()->to('/Movimentacao/form/new/0');
    }
    

    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        $post = $this->request->getPost();

        // Verifica se todos os dados necessários estão definidos
        if (
            isset($post['id']) ||
            isset($post['id_movimentacao']) ||
            isset($post['id_produto']) ||
            isset($post['fornecedor_id']) ||
            isset($post['tipo']) ||
            isset($post['statusRegistro']) ||
            isset($post['setor_id']) ||
            isset($post['data_pedido']) ||
            isset($post['data_chegada']) ||
            isset($post['motivo'])
        ) {

            // Recuperando todos os segmentos da URL
            $segmentos  = service('request')->getURI()->getSegments();
            $action     = $segmentos[2] ?? null;

            // Dados da movimentação
            $id_movimentacao    = $post['id'] ?? $post['id_movimentacao'] ?? "";
            $fornecedor_id      = (int)($post['fornecedor_id'] ?? '');
            $setor_id           = (int)($post['setor_id'] ?? '');
            $data_pedido        = $post['data_pedido'] ?? '';
            $data_chegada       = $post['data_chegada'] ?? '';
            $motivo             = $post['motivo'] ?? '';
            $statusRegistro     = (int)($post['statusRegistro'] ?? '');
            $tipo_movimentacao  = (int)($post['tipo'] ?? '');

            // Dados do produto
            $id_produto         = $post['id_produto'] ?? '';
            $quantidade         = (int)($post['quantidade'] ?? 0);
            $valores_produtos   = $post['valor'] ?? '';

            // Recupera os dados atuais da movimentação
            $dadosAtuais        = $this->model->getLista(); // Supondo que você tenha um método para isso

            // Verifica se os dados atuais são iguais aos dados enviados
            if ($dadosAtuais && 
                (int)$dadosAtuais[0]['id_fornecedor'] === $fornecedor_id &&
                (int)$dadosAtuais[0]['tipo_movimentacao'] === $tipo_movimentacao &&
                (int)$dadosAtuais[0]['statusRegistro'] === $statusRegistro &&
                (int)$dadosAtuais[0]['id_setor'] === $setor_id &&
                $dadosAtuais[0]['data_pedido'] === $data_pedido &&
                $dadosAtuais[0]['data_chegada'] === $data_chegada &&
                $dadosAtuais[0]['motivo'] === $motivo && session()->get('prod_mov_atualizado') !== false) {

                // Retornar mensagem de "nada alterado"
                return redirect()->to('/Movimentacao/form/update/' . $id_movimentacao)->with("msgError", "Nenhuma alteração detectada.");
            } else {
                
                $produtoMovAtualizado       = session()->get('prod_mov_atualizado') ?? [];
                $dadosItensMovimentacao     =  $this->movimentacaoItemModel->listaProdutos($id_movimentacao);

                $quantidade_movimentacao    = 0;
                $found                      = false;

                foreach ($dadosItensMovimentacao as $item) {
                    if ($id_produto == $item['id_prod_mov_itens'] && $id_movimentacao == $item['id_movimentacoes']) {
                        $quantidade_movimentacao = ($tipo_movimentacao == 1) 
                            ? $item['mov_itens_quantidade'] + $quantidade 
                            : $item['mov_itens_quantidade'] - $quantidade;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $quantidade_movimentacao = $quantidade;
                }

                $acaoProduto = $found ? 'update' : 'new';

                // Validação de quantidade em estoque
                $dadosProduto = $this->produtoModel->recuperaProduto($id_produto);
                $estoqueNegativo = false;

                if (!empty($dadosProduto)) {
                    if ($dadosProduto['quantidade'] < $quantidade && $tipo_movimentacao == 2) {
                        $estoqueNegativo = true;
                    }
                }

                if ($tipo_movimentacao == 1) {
                    $estoqueNegativo = false;
                }

                if ($action != 'updateProdutoMovimentacao') {
                   
                    // lista os produtos da movimentação que está sendo alterada
                    foreach ($dadosItensMovimentacao as $item) {
                        $quantidade_produto_movimentacao = $item['mov_itens_quantidade'];

                        // Verifica se o produto foi encontrado e obtém a quantidade e nome
                        if (isset($dadosProduto['quantidade']) && isset($dadosProduto['nome'])) {
                            $quantidade_produto_atual_valor = $dadosProduto['quantidade'];
                            $nome_produto = $dadosProduto['nome'];

                            // Ajusta a quantidade nova com base no tipo de movimentação
                            $quantidade_nova = ($tipo_movimentacao == '1') 
                                ? $quantidade_produto_atual_valor + $quantidade_produto_movimentacao 
                                : $quantidade_produto_atual_valor - $quantidade_produto_movimentacao;

                            // Se a nova quantidade for negativa, adiciona o nome do produto ao array
                            if ($quantidade_nova < 0) {
                                $produtos_negativos[] = $nome_produto;
                            }
                        }
                    }

                    // Verifica se há produtos que ficariam com estoque negativo
                    if (!empty($produtos_negativos)) {
                        $produtos = implode(', ', $produtos_negativos);
                        return redirect()->to('/Movimentacao')->with('msgError', 'Não é permitido alterar esta movimentação: Estoque ficará negativo para os produtos: ' . $produtos);
                    } else {

                        // Variáveis para armazenar a quantidade e tipo de movimentação
                        $produtos_negativos = [];
                        $mov_saida_prod_qtd_negativa = false;

                        $movimentacoes = $this->model->getLista();

                        // Variáveis para armazenar o status e tipo de movimentação
                        $produto_encontrado_outra_movimentacao = false;
                        $quantidade_total = isset($dadosProduto['quantidade']) ? $dadosProduto['quantidade']: ""; // Inicia com a quantidade do produto atual

                        // Lista as movimentações no banco de dados
                        foreach ($movimentacoes as $movimentacao) {
                            $dadosItensMovimentacao = $this->movimentacaoItemModel->listaProdutos($movimentacao['id_movimentacao']);

                            foreach ($dadosItensMovimentacao as $item_movimentacao) {
                                if ($tipo_movimentacao == '2') { // Verifica se é uma movimentação de saída

                                    // Confirma se o item da movimentação é o produto desejado e não é a mesma movimentação atual
                                    if ($item_movimentacao['id_prod_mov_itens'] == $id_produto && $item_movimentacao['id_movimentacoes'] != $id_movimentacao) {
                                        $produto_encontrado_outra_movimentacao = true;
                                    }

                                    // Verifica se a movimentação é a atual e calcula a quantidade
                                    if ($item_movimentacao['id_movimentacoes'] == $id_movimentacao) {
                                        // Atualiza a quantidade subtraindo o item da movimentação
                                        $quantidade_total -= (2 * $item_movimentacao['mov_itens_quantidade']);

                                        // Se a quantidade total ficar negativa, sinaliza e interrompe o loop
                                        if ($quantidade_total < 0) {
                                            
                                            // Adiciona o nome do produto ao array
                                            $produtos_negativos[] = $item_movimentacao['nome'];
                                            $mov_saida_prod_qtd_negativa = true;
                                            break 2; // Sai dos loops aninhados se encontrar quantidade negativa
                                        }
                                    }
                                }
                            }
                        }

                        // Verifica se há produtos com quantidade negativa e monta a mensagem
                        if ($tipo_movimentacao == '2' && !$produto_encontrado_outra_movimentacao && $mov_saida_prod_qtd_negativa) {
                            // Concatena os nomes dos produtos com quantidade negativa em uma string
                            $produtos = implode(', ', $produtos_negativos);
                            return redirect()->to('/Movimentacao')->with('msgError', 'Não é permitido alterar esta movimentação para saída de itens: Estoque ficará negativo para os produtos: ' . $produtos);
                        } else {
                            // Atualiza a movimentação e produtos
                            $atualizandoMovimentacaoEProdutos = $this->model->updateMovimentacao(
                                $id_movimentacao,
                                [
                                    "id_fornecedor"     => $fornecedor_id,
                                    "tipo"              => $tipo_movimentacao,
                                    "statusRegistro"    => $statusRegistro,
                                    "id_setor"          => $setor_id,
                                    "data_pedido"       => $data_pedido,
                                    "data_chegada"      => $data_chegada,
                                    "motivo"            => $motivo
                                ],
                                $produtoMovAtualizado
                            );

                            if ($atualizandoMovimentacaoEProdutos) {
                                session()->remove('prod_mov_atualizado'); // Remover a sessão se existir
                                // session()->remove('movimentacao');
                                // session()->remove('produtos');

                                return redirect()->to('/Movimentacao')->with("msgSuccess", "Movimentação alterada com sucesso.");
                            } else {
                                return redirect()->to('/Movimentacao/form/update/' . $id_movimentacao)->with("msgError", "Falha ao tentar alterar a movimentação.");
                            }
                        }
                    }
      
                } elseif ($action == 'updateProdutoMovimentacao') {
                    if (!$estoqueNegativo) {
                        $atualizandoInfoProdutoMovimentacao = $this->model->updateInformacoesProdutoMovimentacao(
                            $id_movimentacao,
                            [
                                [
                                    "id_produtos"   => $id_produto,
                                    "valor"         => $valores_produtos
                                ]
                            ],
                            [
                                'acaoProduto' => $acaoProduto
                            ],
                            $quantidade,
                            $quantidade_movimentacao
                        );

                        if ($atualizandoInfoProdutoMovimentacao) {
                            session()->set('prod_mov_atualizado', true);
                            // session()->remove('movimentacao');
                            // session()->remove('produtos');

                            return redirect()->to('/Movimentacao/form/update/' . $id_movimentacao)->with("msgSuccess", "Movimentação alterada com sucesso.");
                        }
                    } else {
                        return redirect()->to('/Movimentacao/form/update/' . $id_movimentacao)->with("msgError", "Quantidade da movimentação de saída maior que a do produto em estoque.");
                    }
                } else {
                    return redirect()->to('/Movimentacao/form/update/' . $id_movimentacao)->with("msgError", "Falha ao tentar alterar a movimentação.");
                }
            }
        }
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();

        // Recupera a movimentação detalhada com base no ID
        $movimentacao = $this->model->getMovimentacaoDetalhada($post['id']);

        // Variáveis para armazenar a quantidade e tipo de movimentação
        $quantidade_nova    = 0;
        $produtos_negativos = []; // Array para armazenar os nomes dos produtos que ficarão negativos

        // Verifica se a movimentação existe
        if (!is_array($movimentacao) || empty($movimentacao)) {
            return redirect()->to('/Movimentacao')->with('msgError', 'Movimentação não encontrada.');
        }

        foreach ($movimentacao as $item) {
            $tipo_movimentacao                  = $item['tipo_movimentacao'];
            $quantidade_produto_movimentacao    = $item['quantidade'];
            $id_produto_movimentacao            = $item['id_produtos'];

            // Recupera a quantidade atual do produto e o nome do produto
            $quantidade_produto_atual = $this->produtoModel->recuperaProduto($id_produto_movimentacao);

            // Verifica se o produto foi encontrado e obtém a quantidade e nome
            if (isset($quantidade_produto_atual['quantidade']) && isset($quantidade_produto_atual['nome'])) {
                $quantidade_produto_atual_valor = $quantidade_produto_atual['quantidade']; // Quantidade atual
                $nome_produto                   = $quantidade_produto_atual['nome']; // Nome do produto

                // Ajusta a quantidade nova com base no tipo de movimentação
                if ($tipo_movimentacao == '1') {
                    $quantidade_nova = ($quantidade_produto_atual_valor - $quantidade_produto_movimentacao);
                    // Se a nova quantidade for negativa, adiciona o nome do produto ao array
                    if ($quantidade_nova < 0) {
                        $produtos_negativos[] = $nome_produto;
                    }
                } else {
                    $quantidade_nova = ($quantidade_produto_atual_valor + $quantidade_produto_movimentacao);
                }
            }
        }

        // Verifica se a quantidade nova é negativa
        if ($quantidade_nova >= 0) {
            // Excluir a movimentação
            if ($this->model->delete($post['id'])) {
                return redirect()->to('/Movimentacao')->with('msgSuccess', 'Movimentação excluída com sucesso.');
            } else {
                return redirect()->to('/Movimentacao')->with('msgError', 'Falha ao tentar excluir a Movimentação.');
            }
        } else {
            // Formata a mensagem com os produtos que ficariam negativos
            $produtos = implode(', ', $produtos_negativos); // Cria uma string com os nomes dos produtos
            return redirect()->to('/Movimentacao')->with('msgError', 'Não é permitido excluir esta movimentação: Estoque ficará negativo para os produtos: ' . $produtos);
        }
    }


    /**
     * getProdutoComboBox function
     *
     * @return void
     */
    public function getProdutoComboBox()
    {

        // Recuperando todos os segmentos da URL
        $segmentos  = $this->request->getURI()->getSegments(3);

        // Acessando o primeiro segmento
        $termo      = $segmentos[2] ?? null;

        $dados      = $this->model->getProdutoCombobox($termo);

        echo json_encode($dados);

    }

}