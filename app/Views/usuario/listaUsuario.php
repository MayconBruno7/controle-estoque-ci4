<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- Navbar, Sidebar e Conteúdo aqui -->
        <main class="container mt-5">
            <div class="row">
                <!-- mensagem de erro ou sucesso -->
            </div>
            <div class="container mb-3">
            <?= exibeTitulo('Usuario'); ?>

            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    Lista de Usuários
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbListausuario" class="table table-striped table-hover dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tbListausuario" rowspan="1" colspan="1" style="width: 113.297px;" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListausuario" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Nome</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListausuario" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">E-mail</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListausuario" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Usuario: activate to sort column ascending">Nível</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListausuario" rowspan="1" colspan="1" style="width: 79.5938px;" aria-label="Status do Usuario: activate to sort column ascending">Status</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListausuario" rowspan="1" colspan="1" style="width: 79.875px;" aria-label="Opções: activate to sort column ascending">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $value): ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?= $value['id'] ?></td>
                                        <td><?= $value['nome'] ?></td>
                                        <td><?= $value['email'] ?></td>
                                        <td><?= ($value['nivel'] == 1 ? "Administrador" : "Usuário") ?></td>
                                        <td><?= getStatusDescricao($value['statusRegistro']) ?></td>
                                        <td>
                                            <a href="/Usuario/form/view/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>    
                                            <a href="/Usuario/form/update/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Alterar"><i class="fa fa-file" aria-hidden="true"></i></a>    
                                            <a href="/Usuario/form/delete/<?= $value['id'] ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></a>   
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?= getDataTables("tbListausuario"); ?>
    </div>
</div>

<?= $this->endSection() ?>