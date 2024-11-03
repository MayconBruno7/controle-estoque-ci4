<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<main class="container mt-5">

    <div class="container" style="margin-top: 130px;">
        <?= exibeTitulo("Setor", ['acao' => $action]) ?>
    </div>

    <!-- pega se é new, delete ou update a partir do metodo get assim mandando para a página correspondente -->
    <?= form_open(base_url() . 'Setor/' . ($action == "delete" ? "delete" : "store")) ?>

        <div class="row">

            <div class="col-12 col-md-8">
                <label for="nome" class="form-label mt-3">Nome</label>
                <!--  verifica se a nome está no banco de dados e retorna essa nome -->
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome do setor" required autofocus value="<?= setValor('nome', $data) ?>" <?= $action != 'new' && $action != 'update' ? 'disabled' : '' ?>>
                <?= setaMsgErrorCampo('nome', $errors) ?>
            </div>

            <div class="col-12 col-md-4">
                <label for="statusRegistro" class="form-label mt-3">Status</label>
                <select name="statusRegistro" id="statusRegistro" class="form-control" required <?= $action != 'new' && $action != 'update' ? 'disabled' : '' ?>>
                    <!--  verifica se o statusRegistro está no banco de dados e retorna esse statusRegistro -->
                    <option value=""  <?= setValor('statusRegistro', $data) == ""  ? "SELECTED": "" ?>>...</option>
                    <option value="1" <?= setValor('statusRegistro', $data) == "1" ? "SELECTED": "" ?>>Ativo</option>
                    <option value="2" <?= setValor('statusRegistro', $data) == "2" ? "SELECTED": "" ?>>Inativo</option>
                </select>
                <?= setaMsgErrorCampo('statusRegistro', $errors) ?>

            </div>

            <div class="col-12 col-md-12 mt-4">
                <label for="funcionarios" class="form-label">Responsavel pelo setor</label>
                <select name="funcionarios" id="funcionarios" class="form-control" 
                <?= $action != 'new' && $action != 'update' ? 'disabled' : '' ?>
                <?= !empty($aFuncionario) ? 'required' : '' ?>   
                >
                    <option value="">...</option> <!-- Opção padrão -->
                    <?php foreach ($aFuncionario as $value): ?>
                        <option value="<?= $value['id'] ?>" <?= $value['id'] == setValor('id', $data) ? 'selected' : '' ?>>
                            <?= $value['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= setaMsgErrorCampo('funcionarios', $errors) ?>

            </div>
        </div>

        <!--  verifica se o id está no banco de dados e retorna esse id -->
        <input type="hidden" name="id" id="id" value="<?= setValor('id', $data) ?>">
        <input type="hidden" name="action" id="action" value="<?= $action ?>">

        <div class="form-group col-12 mt-5">
            <?php if ($action != "view"): ?>
                <button type="submit" value="submit" id="btGravar" class="btn btn-primary btn-sm">Gravar</button>
            <?php endif; ?>
        </div>
    <?= form_close() ?>

    <?php if ($action == "view"): ?>
        <button onclick="goBack()" class="btn btn-secondary">Voltar</button>
    <?php endif; ?>

</main>

<script>
    function goBack() {
        window.history.go(-1);
    }
</script>

<?= $this->endSection() ?>
