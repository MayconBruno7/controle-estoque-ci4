<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- Navbar, Sidebar e Conteúdo aqui -->
        <main class="container mt-5">
            <div class="container mb-3">
                <?= exibeTitulo('Funcionario'); ?>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    Lista de Funcionários
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbListafuncionario" class="table table-striped table-hover dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tbListafuncionario" rowspan="1" colspan="1" style="width: 113.297px;" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafuncionario" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Nome: activate to sort column ascending">Nome</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafuncionario" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Salário: activate to sort column ascending">Salário</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafuncionario" rowspan="1" colspan="1" style="width: 175.656px;" aria-label="Setor: activate to sort column ascending">Setor</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafuncionario" rowspan="1" colspan="1" style="width: 79.5938px;" aria-label="Status: activate to sort column ascending">Status</th>
                                    <th class="sorting" tabindex="0" aria-controls="tbListafuncionario" rowspan="1" colspan="1" style="width: 79.875px;" aria-label="Opções: activate to sort column ascending">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($funcionarios as $value): ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?= $value['id'] ?></td>
                                        <td><?= $value['nome'] ?></td>
                                        <td>R$ <?= number_format($value['salario'], 2, ',', '.') ?></td>
                                        <td><?= $value['nome_do_setor'] ? : "Nenhum setor selecionado" ?></td>
                                        <td><?= getStatusDescricao($value['statusRegistro']) ?></td>
                                        <td>
                                            <a href="/Funcionario/form/view/<?= $value['id'] ?>" class="btn btn-secondary btn-sm" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <a href="/Funcionario/form/update/<?= $value['id'] ?>" class="btn btn-secondary btn-sm" title="Alterar"><i class="fa fa-file" aria-hidden="true"></i></a>
                                            <a href="/Funcionario/form/delete/<?= $value['id'] ?>" class="btn btn-secondary btn-sm" title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?= getDataTables("tbListafuncionario"); ?>
    </div>
</div>

<?= $this->endSection() ?>
