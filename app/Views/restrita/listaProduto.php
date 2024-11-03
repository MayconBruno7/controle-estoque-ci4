<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<?php

    if (empty($action)) {
        // Recuperando todos os segmentos da URL
        $segmentos = service('request')->getURI()->getSegments();

        // Acessando o terceiro segmento (index 2, já que começa em 0)
        $action             = $segmentos[2] ?? null; 
        $id_produto         = $segmentos[3] ?? null; 
        $quantidade_atual   = $segmentos[4] ?? null; 
        $tipo               = $segmentos[5] ?? null; 
        $id_movimentacao    = $segmentos[6] ?? null; 
        $valor              = $segmentos[7] ?? null; 
    }

?>

<div class="loader"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- Navbar, Sidebar e Conteúdo aqui -->
        <main class="container mt-5">
            <div class="container mb-3">
                <?= exibeTitulo('Produto'); ?>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    Lista de Produtos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbListaProduto" class="table table-striped table-hover dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tbListaProduto" rowspan="1" colspan="1" style="width: 113.297px;" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListaProduto" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Nome Produto</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListaProduto" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Quantidade</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListaProduto" rowspan="1" colspan="1" style="width: 79.5938px;" aria-label="Status do Usuario: activate to sort column ascending">Valor</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListaProduto" rowspan="1" colspan="1" style="width: 79.5938px;" aria-label="Status do Usuario: activate to sort column ascending">Estado do produto</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListaProduto" rowspan="1" colspan="1" style="width: 79.5938px;" aria-label="Status do Usuario: activate to sort column ascending">Status do produto</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListaProduto" rowspan="1" colspan="1" style="width: 79.875px;" aria-label="Opções: activate to sort column ascending">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $value): ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?= $value['id'] ?></td>
                                        <td><?= $value['nome'] ?></td>
                                        <td><?= !empty($value['quantidade']) ? number_format($value['quantidade'], 2, ",", ".") : '0,00' ?></td>
                                        <td><?= !empty($value['valor']) ? number_format($value['valor'], 2, ",", ".") : "Não encontrado" ?></td>
                                        <td><?= getCondicao($value['condicao']) ?></td>
                                        <td><?= getStatusDescricao($value['statusRegistro']) ?></td>
                                        <td>
                                        <?php if (isset($action) && $action == 'delete') : ?>
                                            <?= form_open(base_url('Movimentacao/deleteProdutoMovimentacao/' . $action), ['method' => 'post']) ?>
                                            <p>Quantidade atual: <?= $quantidade_atual ?></p>
                                                <label for="quantidadeRemover" class="form-label">Quantidade</label>
                                                <input type="number" name="quantidadeRemover" id="quantidadeRemover" class="form-control" required></input>

                                                <input type="hidden" name="id_produto" value="<?= $id_produto ?>">
                                                <input type="hidden" name="id_movimentacao" value="<?= $id_movimentacao ?>">
                                                <input type="hidden" name="tipo" value="<?= $tipo ?>">
                                                <input type="hidden" name="valor" value="<?= $valor ?>">
                                                <button type="submit" class="btn btn-primary btn-sm mt-2">Remover</button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if (!isset($action)) : ?>
                                            <a href="/Produto/form/view/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>    
                                            <a href="/Produto/form/update/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Alterar"><i class="fa fa-file" aria-hidden="true"></i></a>    
                                            <a href="/Produto/form/delete/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></a>   
                                        <?php endif; ?>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?= getDataTables("tbListaProduto"); ?>
    </div>
</div>

<?= $this->endSection() ?>