<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<div class="loader"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1 "  style="margin-top: 200px;">
        <!-- Navbar, Sidebar e Conteúdo aqui -->
        <main class="container mt-5">
            <div class="row">
                <!-- mensagens de erro ou sucesso -->
            </div>

            <div class="container mb-5 text-center">
                <h1>Histórico - <?= $produto['nome'] ?></h1>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    Lista de fornecedores
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbListasetor" class="table table-striped table-hover dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 113.297px;" aria-sort="ascending" aria-label="ID: activate to sort column descending">Pedido</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Fornecedor</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Tipo</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Data do pedido</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Data de chegada</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Quantidade</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Total</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 79.875px;" aria-label="Opções: activate to sort column ascending">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ($dados) {
                                        foreach ($dados as $row) {
                                            ?>
                                                <tr>
                                                    <td> <?= isset($row['id_mov']) ? $row['id_mov'] : 'Nenhuma movimentação encontrada' ?> </td>
                                                    <td> <?= isset($row['nome_fornecedor']) ? $row['nome_fornecedor'] : 'Nenhum fornecedor encontrado' ?> </td>
                                                    <td> <?= isset($row['tipo']) ? getTipoMovimentacao($row['tipo']) : 'Nenhum tipo de movimentação' ?></td>
                                                    <td> <?= isset($row['data_pedido']) ? date('d/m/Y', strtotime($row['data_pedido'])) : 'Nenhuma data de pedido encontrada' ?> </td>
                                                    <td> <?= isset($row['data_chegada']) && $row['data_chegada'] != '0000-00-00' ? date('d/m/Y', strtotime($row['data_chegada'])) : 'Nenhuma data de chegada encontrada' ?> </td>
                                                    <td> <?= isset($row['Quantidade']) ? $row['Quantidade'] : 'Nenhuma '?> </td>
                                                    <td> <?= isset($row['Valor']) ? number_format($row['Valor'], 2, ",", "."): 'Nenhuma '?> </td>
                                                    <td>
                                                        <a href="<?= base_url() ?>Movimentacao/Form/view/<?= $row['id_mov'] ?>" class="btn btn-outline-secondary btn-sm styleButton" title="Visualizar">Visualizar</a>&nbsp;
                                                        <a href="<?= base_url() ?>Movimentacao/Form/update/<?= $row['id_mov'] ?>" class="btn btn-outline-primary btn-sm styleButton" title="Alteração">Alterar</a>&nbsp;
                                                        <a href="<?= base_url() ?>Movimentacao/Form/<?= $row['id_mov'] ?>" class="btn btn-outline-danger btn-sm styleButton" title="Exclusão">Excluir</a>&nbsp;
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <div class="row justify-content-center">
            <div class="col-6 d-flex justify-content-center">
                <?php if ($action == "view"): ?>
                    <button onclick="goBack()" class="btn btn-secondary">Voltar</button>
                <?php endif; ?>
            </div>
        </div>

        <script>

            function goBack() {
                window.history.go(-1);
            }

        </script>

<?= getDataTables("listaProdutos"); ?>

<?= $this->endSection() ?>

