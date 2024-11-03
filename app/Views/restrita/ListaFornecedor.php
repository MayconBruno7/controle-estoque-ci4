<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<div class="loader"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- Navbar, Sidebar e Conteúdo aqui -->
        <main class="container mt-5">
            <div class="container mb-3">
                <?= exibeTitulo('Fornecedor'); ?>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    Lista de fornecedores
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbListafornecedor" class="table table-striped table-hover dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tbListafornecedor" rowspan="1" colspan="1" style="width: 113.297px;" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafornecedor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Nome</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafornecedor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">CNPJ</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafornecedor" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Telefone</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafornecedor" rowspan="1" colspan="1" style="width: 79.5938px;" aria-label="Status do Usuario: activate to sort column ascending">Status</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafornecedor" rowspan="1" colspan="1" style="width: 79.875px;" aria-label="Opções: activate to sort column ascending">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fornecedores as $value): ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?= $value['id'] ?></td>
                                        <td><?= $value['nome'] ?></td>
                                        <td><?= formatarCNPJInput($value['cnpj']) ?></td>
                                        <td><?= formatarTelefone($value['telefone']) ?></td>
                                        <td><?= getStatusDescricao($value['statusRegistro']) ?></td>
                                        <td>
                                            <a href="/Fornecedor/form/view/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>    
                                            <a href="/Fornecedor/form/update/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Alterar"><i class="fa fa-file" aria-hidden="true"></i></a>    
                                            <a href="/Fornecedor/form/delete/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></a>   
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?= getDataTables("tbListafornecedor"); ?>
    </div>
</div>
<?= $this->endSection() ?>