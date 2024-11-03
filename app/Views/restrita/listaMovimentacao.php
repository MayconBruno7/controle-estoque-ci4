<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<div class="loader"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- Navbar, Sidebar e Conteúdo aqui -->
        <main class="container mt-5">
            <div class="container mb-3">
                <?= exibeTitulo('Movimentacao'); ?>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    Lista de Movimentações
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbListasetor" class="table table-striped table-hover dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 113.297px;" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Fornecedor</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Tipo</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Data do pedido</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Data chegada</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Status Registro</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListasetor" rowspan="1" colspan="1" style="width: 79.875px;" aria-label="Opções: activate to sort column ascending">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($movimentacoes as $row): ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?= $row['id_movimentacao'] ?></td>
                                        <td><?= $row['nome_fornecedor'] ?></td>
                                        <td><?= getTipo($row['tipo_movimentacao']) ?></td>
                                        <td><?= formatarDataBrasileira($row['data_pedido']) ?></td>
                                        <td><?= $row['data_chegada'] != '0000-00-00' ? formatarDataBrasileira($row['data_chegada']) : 'Nenhuma data encontrada' ?></td>
                                        <td><?= getStatusDescricao($row['statusRegistro']) ?></td>
                                        <td class="text-center">
                                            <div class="dropdown dropdown-action p-0">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu p-0 m-0 text-center">
                                                    <a href="/Movimentacao/form/view/<?= $row['id_movimentacao'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Visualizar">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>    
                                                    <a href="/Movimentacao/form/update/<?= $row['id_movimentacao'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Alterar">
                                                        <i class="fa fa-file" aria-hidden="true"></i>
                                                    </a>    
                                                    <a href="/Movimentacao/form/delete/<?= $row['id_movimentacao'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Excluir">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>   
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?= getDataTables("tbListasetor"); ?>
    </div>
</div>

<?= $this->endSection() ?>