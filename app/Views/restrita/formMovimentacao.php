<?php

    $this->extend('layout/layout_default');

    $this->section('conteudo'); 

    // Verificar se há uma sessão de movimentação
    if (!session()->has('movimentacao')) {
        session()->get('movimentacao');
    }

    $dadosMovimentacao = session()->get('movimentacao');

    $total = 0;

?>

<main class="container mt-5">

    <div class="modal fade" id="modalAdicionarProduto" tabindex="-1" aria-labelledby="modalAdicionarProdutoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarProdutoLabel">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?= form_open(
                        base_url('Movimentacao/' . ($action == 'update' ? 'update/updateProdutoMovimentacao/' . setValor('id', $data) : 'newProdutoMovimentacao/' . $action)),
                        ['id' => 'formAdicionarProduto', 'method' => 'POST']
                    ) ?>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="id_produto" class="form-label">Produto</label>
                                <input type="text" class="form-control" id="search_produto" placeholder="Pesquisar produto">
                                <select class="form-control" name="id_produto" id="id_produto" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                                    <option value="" selected disabled>Vazio</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" id="quantidade" name="quantidade" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor Unitário</label>
                            <input type="number" step="0.01" class="form-control" id="valor" name="valor" min="0" required>
                        </div>

                        <input type="hidden" name="id_movimentacao" value="<?= setValor('id', $data) ?>">
                        <input type="hidden" name="tipo" value="<?= setValor('tipo', $data) ?>">
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                        <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 130px;">
        <?= exibeTitulo("Movimentacao", ['acao' => $action]) ?>
    </div>

    <?= form_open(base_url() . 'Movimentacao/' . ($action), ['method' => 'post']) ?>

    <!--  verifica se o id está no banco de dados e retorna esse id -->
    <input type="hidden" name="id" id="id" value="<?= setValor('id', $data) ?>">

    <?php if ($action == 'new') : ?>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 mt-3">
            <label for="fornecedor_id" class="form-label">Fornecedor</label>
            <select name="fornecedor_id" id="fornecedor_id" class="form-control" required <?= $action != 'new' && $action != 'update' ? 'disabled' : ''?>>
                <option value="">...</option>
                <?php foreach($aFornecedor as $fornecedor) : ?>
                    <option value="<?= $fornecedor['id'] ?>" <?= isset($dadosMovimentacao['fornecedor_id']) && $dadosMovimentacao['fornecedor_id'] == $fornecedor['id'] ? 'selected' : '' ?>>
                        <?= $fornecedor['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 col-md-6 mt-3">
            <label for="tipo" class="form-label">Tipo de Movimentação</label>
            <select name="tipo" id="tipo" class="form-control" required <?= $action != 'new' && $action != 'update' ? 'disabled' : ''?>>
                <option value="">...</option>
                <option value="1" <?= isset($dadosMovimentacao['tipo_movimentacao']) && $dadosMovimentacao['tipo_movimentacao'] == 1 ? 'selected' : '' ?>>Entrada</option>
                <option value="2" <?= isset($dadosMovimentacao['tipo_movimentacao']) && $dadosMovimentacao['tipo_movimentacao'] == 2 ? 'selected' : '' ?>>Saída</option>
            </select>
        </div>

        <div class="col-12 mt-3">
            <label for="statusRegistro" class="form-label">Status da Movimentação</label>
            <select name="statusRegistro" id="statusRegistro" class="form-control" required <?= $action != 'new' && $action != 'update' ? 'disabled' : ''?>>
                <option value="">...</option>
                <option value="1" <?= isset($dadosMovimentacao['statusRegistro']) && $dadosMovimentacao['statusRegistro'] == 1 ? 'selected' : '' ?>>Ativo</option>
                <option value="2" <?= isset($dadosMovimentacao['statusRegistro']) && $dadosMovimentacao['statusRegistro'] == 2 ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>

        <div class="col-12 mt-3">
            <label for="setor_id" class="form-label">Setor</label>
            <select name="setor_id" id="setor_id" class="form-control" required <?= $action != 'new' && $action != 'update' ? 'disabled' : '' ?>>
                <option value="">...</option>
                <?php foreach ($aSetor as $setor): ?>
                    <option value="<?= $setor['id'] ?>" <?= (isset($dadosMovimentacao['setor_id']) && $dadosMovimentacao['setor_id'] == $setor['id']) ? 'selected' : '' ?>>
                        <?= $setor['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 col-md-6 mt-3">
            <label for="data_pedido" class="form-label">Data do Pedido</label>
            <!--  verifica se a nome está no banco de dados e retorna essa nome -->
            <input type="date" class="form-control" name="data_pedido" id="data_pedido" placeholder="data_pedido do item" required autofocus value="<?= isset($dadosMovimentacao['data_pedido']) ? $dadosMovimentacao['data_pedido'] : "" ?>" max="<?= date('Y-m-d') ?>" <?= $action && ($action == 'delete' || $action == 'view') ? 'disabled' : '' ?>>
        </div>

        <div class="col-12 col-md-6 mt-3">
            <label for="data_chegada" class="form-label">Data de Chegada</label>
            <!-- verifica se a data_chegada está no banco de dados e retorna essa data -->
            <input type="date" class="form-control" name="data_chegada" id="data_chegada" placeholder="data_chegada do item" value="<?= isset($dadosMovimentacao['data_chegada']) ? $dadosMovimentacao['data_chegada'] : "" ?>" max="<?= date('Y-m-d') ?>" min="<?= setValor('data_pedido', $data) ?>" <?=$action && ($action == 'delete' || $action == 'view') ? 'disabled' : '' ?>>
        </div>

        <div class="col-12 mt-3">
            <label for="motivo" class="form-label">Motivo</label>
            <textarea class="form-control" name="motivo" id="motivo" placeholder="Detalhe o motivo" <?=$action != 'new' &&$action != 'update' ? 'readonly' : ''?>><?= isset($dadosMovimentacao['motivo']) ? htmlspecialchars($dadosMovimentacao['motivo']) : '' ?></textarea>
        </div>
    </div>
    <?php endif; ?>
        
    <?php if ($action != 'new') : ?>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 mt-3">
            <label for="fornecedor_id" class="form-label">Fornecedor</label>
            <select name="fornecedor_id" id="fornecedor_id" class="form-control" required <?=$action == 'view' ||$action == 'delete' ? 'disabled' : '' ?>>
                <option value="">...</option>
                <?php foreach($aFornecedor as $fornecedor) : ?>
                    <option value="<?= $fornecedor['id'] ?>" <?= setValor('id_fornecedor', $data) == $fornecedor['id'] ? 'selected' : '' ?>>
                        <?= $fornecedor['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 col-md-3 mt-3">
            <label for="tipo" class="form-label">Tipo de Movimentação</label>
            <select name="tipo" id="tipo" class="form-control" required <?=$action == 'view' ||$action == 'delete' ? 'disabled' : '' ?>>
                <option value="">...</option>
                <option value="1" <?= setValor('tipo', $data) == 1 ? 'selected' : '' ?>>Entrada</option>
                <option value="2" <?= setValor('tipo', $data) == 2 ? 'selected' : '' ?>>Saída</option>
            </select>
        </div>

        <div class="col-12 mt-3">
            <label for="statusRegistro" class="form-label">Status da Movimentação</label>
            <select name="statusRegistro" id="statusRegistro" class="form-control" required <?=$action == 'view' ||$action == 'delete' ? 'disabled' : '' ?>>
                <option value="">...</option>
                <option value="1" <?= setValor('statusRegistro', $data) == 1 ? 'selected' : '' ?>>Ativo</option>
                <option value="2" <?= setValor('statusRegistro', $data) == 2 ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>

        <div class="col-12 mt-3">
            <label for="setor_id" class="form-label">Setor</label>
            <select name="setor_id" id="setor_id" class="form-control" required <?=$action == 'view' ||$action == 'delete' ? 'disabled' : '' ?>>
                <option value="">...</option>
                <?php foreach ($aSetor as $setor): ?>
                    <option value="<?= $setor['id'] ?>" <?= setValor('id_setor', $data) ? 'selected' : '' ?>>
                        <?= $setor['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 col-md-6 mt-3">
            <label for="data_pedido" class="form-label">Data do Pedido</label>
            <!--  verifica se a nome está no banco de dados e retorna essa nome -->
            <input type="date" class="form-control" name="data_pedido" id="data_pedido" placeholder="data_pedido do item" required autofocus value="<?= setValor('data_pedido', $data) ?>" max="<?= date('Y-m-d') ?>" <?=$action == 'view' ||$action == 'delete' ? 'disabled' : '' ?>>
        </div>

        <div class="col-12 col-md-6 mt-3">
            <label for="data_chegada" class="form-label">Data de Chegada</label>
            <!--  verifica se a nome está no banco de dados e retorna essa nome -->
            <input type="date" class="form-control" name="data_chegada" id="data_chegada" placeholder="data_chegada do item" value="<?= setValor('data_chegada', $data) ?>" min="<?= setValor('data_pedido', $data) ?>" max="<?= date('Y-m-d') ?>" <?=$action == 'view' ||$action == 'delete' ? 'disabled' : '' ?>>
        </div>


        <div class="col-12 mt-3">
            <label for="motivo" class="form-label">Motivo</label>
            <textarea class="form-control" name="motivo" id="motivo" placeholder="Detalhe o motivo" <?=$action == 'view' ||$action == 'delete' ? 'disabled' : '' ?>><?= setValor('motivo', $data) ?></textarea>
        </div>
        <?php endif; ?>

        <!-- <a href="<?= base_url() ?>Movimentacao/salvarSessao/new/0">teste</a>     -->

        <div class="col mt-4">
            <div class="col-md-8">
                <h3 class="d-inline">Produtos do pedido</h3>
            </div>
        </div>

        <div class="col mt-4">
            <div class="col-auto text-end ml-2">
            <?php if ($action != "view" && $action != "delete"): ?>
                <button type="button" class="btn btn-outline-primary btn-sm" id="<?= ($action == 'new') ? 'btnAdicionaProdutoInsert' : 'btnAdicionaProdutoUpdate' ?>" <?= ($action == 'update') ? 'data-bs-toggle="modal" data-bs-target="#modalAdicionarProduto"' : '' ?>>
                    Adicionar Produtos
                </button>
            <?php endif; ?>
            </div>
        </div>

        <table id="tbListaProduto" class="table table-striped table-hover table-bordered table-responsive-sm mt-3">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Produto</th>
                <th>Valor Unitário</th>
                <th>Quantidade</th>
                <th>Valor Total</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset(session()->get('movimentacao')['produtos']) && $action == 'new'): ?>
                <?php foreach ($dadosMovimentacao['produtos'] as $produto) : ?>
                    <tr>
                        <td><?= $produto['id_produto'] ?></td>
                        <td><?= $produto['nome_produto'] ?></td>
                        <td><?= number_format($produto['valor'], 2, ",", ".") ?></td>
                        <td><?= number_format($produto['quantidade'], 2, ",", ".") ?></td>
                        <td><?= number_format(($produto['quantidade'] * $produto['valor']), 2, ",", ".") ?></td>
                        <td>
                            <?php if($action != 'delete' &&$action != 'view') : ?>
                                <a href="<?= base_url() ?>Produto/index/delete/<?= $produto['id_produto'] ?>/<?= $produto['quantidade'] ?>/<?= setValor('tipo', $data) ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                                <!-- <a href="viewEstoque.php?acao=delete&id=<?= $produto['id_produto'] ?>&id_movimentacoes=<?= isset($idMovimentacaoAtual) ? $idMovimentacaoAtual : "" ?>&qtd_produto=<?=  isset($produto['quantidade']) ? $produto['quantidade'] : '' ?>&tipo=<?= isset($dadosMovimentacao['tipo_movimentacao']) ? $dadosMovimentacao['tipo_movimentacao'] : '' ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp; -->
                            <?php endif; ?>
                                <a href="<?= base_url() ?>Produto/form/view/<?= $produto['id_produto'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                        </td>
                    </tr>

                    <div class="produto-campo">
                        <input type="hidden" name="quantidade" id="quantidade_value" value="<?= $produto['quantidade'] ?>">
                        <input type="hidden" name="id_produto" id="id_produto_value" value="<?= $produto['id_produto'] ?>">
                        <input type="hidden" name="valor" id="valor_value" value="<?= $produto['valor'] ?>">
                        <input type="hidden" name="nome_produto" id="nome_produto_value" value="<?= $produto['nome_produto'] ?>">
                        <!-- <input type="hidden" name="tipo_movimentacoes" id="tipo_movimentacoes" value="<?= isset($dadosMovimentacao['tipo_movimentacao']) ? $dadosMovimentacao['tipo_movimentacao'] : '' ?>"> -->
                    </div>

                    <?php
                        $total += $produto['quantidade'] * $produto['valor'];
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>
        
            <?php if($action != 'new') : ?>
                <?php

                        foreach ($aItemMovimentacao as $row) {
                    ?>
                    <tr>
                        <td><?= $row['id_prod_mov_itens'] ?></td>
                        <td><?= $row['nome'] ?></td>
                        <td><?= number_format($row['valor'], 2, ",", ".")  ?> </td>
                        <td><?= number_format($row['mov_itens_quantidade'], 2, ",", ".") ?></>
                        <td><?= number_format(($row["mov_itens_quantidade"] * $row["valor"]), 2, ",", ".") ?></td>
                        <td>
                        <?php if($action != 'delete' && $action != 'view') : ?>
                            <a href="<?= base_url() ?>Produto/index/delete/<?= $row['id_prod_mov_itens'] ?>/<?= $row['mov_itens_quantidade'] ?>/<?= setValor('tipo', $data) ?>/<?= setValor('id', $data) ?>/<?= $row['valor'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                            <!-- <a href="viewEstoque.php?acao=delete&id=<?= $row['id'] ?>&id_movimentacoes=<?= $row['id_movimentacoes'] ?>&qtd_produto=<?= $row['mov_itens_quantidade'] ?>&tipo=<?= isset($dados->tipo) ? $dados->tipo : ""?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp; -->
                        <?php endif; ?>
                            <a href="<?= base_url() ?>Produto/form/view/<?= $row['id_prod_mov_itens'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                            <!-- <a href="formProdutos.php?acao=view&id=<?= $row['id'] ?>&id_movimentacoes=<?= $row['id_movimentacoes'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a> -->
                        </td>
                    </tr>

                    <input type="hidden" name="quantidade" id="quantidade" value="<?= $row['mov_itens_quantidade'] ?>">
                    <input type="hidden" name="id_produto" id="id_produto" value="<?= $row['id_prod_mov_itens'] ?>">
                    <input type="hidden" name="valor" id="valor" value="<?= $row['valor'] ?>">
                    <!-- <input type="hidden" name="tipo_movimentacoes" id="tipo_movimentacoes" value="<?= isset($dadosMovimentacao['tipo_movimentacao']) ? $dadosMovimentacao['tipo_movimentacao'] : '' ?>"> -->

                    <?php

                        $total = $total + ($row["mov_itens_quantidade"] * $row["valor"]);

                        }
                    ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p>
        <h2 align="center">
            Valor Total: R$ <?= number_format($total, 2, ',', '.')?>
        </h2>
    </p>
    
    </div>

    <div class="row justify-content-center">
        <div class="col-6 d-flex justify-content-center mt-3">

        <?php //if ($this->getOutrosParametros(4) == "home"): ?>
            <!-- <a href=" //base_url() . Formulario::retornaHomeAdminOuHome() " class="btn btn-primary btn-sm">Voltar</a> -->
        <?php //endif; ?>

        <?php if ($action != "view"): ?>
            <button type="submit" value="submit" id="btGravar" class="btn btn-primary btn-sm">Gravar</button>
        <?php endif; ?>

        </div>
    </div>
    <?= form_close() ?>

    <div class="row justify-content-center">
        <div class="col-6 d-flex justify-content-center">
            <?php if ($action == "view"): ?>
                <button onclick="goBack()" class="btn btn-secondary">Voltar</button>
            <?php endif; ?>
        </div>
    </div>

    </main>

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script>

        function goBack() {
            window.history.go(-1);
        }

        campo_produto = document.getElementById('id_produto_value');

        $(function() {
            $('#search_produto').keyup(function() {
                var termo = $(this).val().trim();

                if (termo.length > 0) {
                    $('#id_produto').hide();
                    $('.carregando').show();

                    
                    $.getJSON('<?= base_url() ?>Movimentacao/getProdutoComboBox/' + termo, 
                    function(data) {
                        console.log(data);
                        var options = '<option value="" selected disabled>Escolha o produto</option>';
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                options += '<option value="' + data[i].id + '">' + data[i].id + ' - ' + data[i].nome + '</option>';
                            }
                        } else {
                            options = '<option value="" selected disabled>Nenhum produto encontrado</option>';
                        }
                        $('#id_produto').html(options).show();
                    })
                    .fail(function() {
                        console.error("Erro ao carregar produtos.");
                        $('#id_produto').html('<option value="" selected disabled>Erro ao carregar produtos</option>').show();
                    })
                    .always(function() {
                        $('.carregando').hide();
                    });
                } else {
                    $('#id_produto').html('<option value="" selected disabled>Escolha um produto</option>').show();
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {

            // Verifica se o botão existe antes de adicionar o evento
            var btnAdicionaProdutoUpdate = document.getElementById('btnAdicionaProdutoUpdate');
            if (btnAdicionaProdutoUpdate) {
                btnAdicionaProdutoUpdate.addEventListener('click', function(event) {
                    event.preventDefault(); // Previne o comportamento padrão de redirecionamento do botão
                    abrirModal(); // Certifique-se que a função está definida corretamente
                });
            }

            var btnSalvar = document.getElementById('btnAdicionaProdutoInsert');
            if (btnSalvar) {
                btnSalvar.addEventListener('click', function(event) {
                    event.preventDefault(); // Previne o comportamento padrão de redirecionamento do botão
                    capturarValores(); // Certifique-se que a função está definida corretamente
                    abrirModal(); // Certifique-se que a função está definida corretamente
                });
            }

            function capturarValores() {
                var fornecedor_id = document.getElementById('fornecedor_id').value;
                var tipo_movimentacao = document.getElementById('tipo').value;
                var statusRegistro = document.getElementById('statusRegistro').value;
                var setor_id = document.getElementById('setor_id').value;
                var data_pedido = document.getElementById('data_pedido').value;
                var data_chegada = document.getElementById('data_chegada').value;
                var motivo = document.getElementById('motivo').value;

                // Array para armazenar os produtos
                var produtos = [];

                // Iterar sobre os campos de produto e capturar seus valores
                var produtosCampos = document.querySelectorAll('.produto-campo');
                produtosCampos.forEach(function(campo) {
                    var id_produto = campo.querySelector('#id_produto_value').value;
                    var nome_produto = campo.querySelector('#nome_produto_value').value;
                    var valor = campo.querySelector('#valor_value').value;
                    var quantidade = campo.querySelector('#quantidade_value').value;

                    produtos.push({
                        'id_produto': id_produto,
                        'nome_produto': nome_produto,
                        'valor': valor,
                        'quantidade': quantidade
                    });
                });

                // Criação do objeto movimentacao
                var movimentacao = {
                    'fornecedor_id': fornecedor_id,
                    'tipo_movimentacao': tipo_movimentacao,
                    'statusRegistro': statusRegistro,
                    'setor_id': setor_id,
                    'data_pedido': data_pedido,
                    'data_chegada': data_chegada,
                    'motivo': motivo,
                    'produtos': produtos 
                };

                //console.log(movimentacao)
                console.log(produtos)            

                fetch('<?= base_url('Movimentacao/salvarSessao/' . $action . '/0') ?>', {                    
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(movimentacao)
                })
                .then(response => {
                    // Logue a resposta como texto antes de converter para JSON
                    // console.log('Resposta recebida:', response);
                    return response.json(); // Isso pode falhar se a resposta não for JSON
                })
                .then(data => {
                    // console.log('Dados enviados com sucesso:', data);
                })
                .catch(error => {
                    // console.log('Erro ao enviar dados:', error);
                });
            }

            function abrirModal() {
                $('#modalAdicionarProduto').modal('show');
            }
        });

    </script>

<?= $this->endSection() ?>