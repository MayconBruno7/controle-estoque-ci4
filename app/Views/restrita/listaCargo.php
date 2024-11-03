<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<div class="loader"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- Navbar, Sidebar e Conteúdo aqui -->
        <main class="container mt-5">
            <div class="container mb-3">
                <?= exibeTitulo("Cargo") ?>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    Lista de Cargos
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbListacargo" class="table table-striped table-hover dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tbListacargo" rowspan="1" colspan="1" style="width: 113.297px;" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListacargo" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Cargo: activate to sort column ascending">Cargo</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListacargo" rowspan="1" colspan="1" style="width: 79.5938px;" aria-label="Status do cargo: activate to sort column ascending">Status do cargo</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListacargo" rowspan="1" colspan="1" style="width: 79.875px;" aria-label="Opções: activate to sort column ascending">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cargos as $value): ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?= $value['id'] ?></td>
                                        <td><?= $value['nome'] ?></td>
                                        <td><?= getStatusDescricao($value['statusRegistro']) ?></td>
                                        <td>
                                            <a href="/Cargo/form/view/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>    
                                            <a href="/Cargo/form/update/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Alterar"><i class="fa fa-file" aria-hidden="true"></i></a>    
                                            <a href="/Cargo/form/delete/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></a>   
                                        </td>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?= getDataTables("tbListacargo"); ?>
    </div>
    <?= $this->endSection() ?>
</div>
