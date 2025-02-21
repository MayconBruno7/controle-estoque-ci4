<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<main class="container mt-5">

    <div class="container" style="margin-top: 130px;">
        <?= exibeTitulo("Setor", ['acao' => $action]) ?>
    </div>

    <?= form_open(base_url() . 'Setor/' . ($action == "delete" ? "delete" : "store")) ?>

        <div class="row">

            <div class="col-12 col-md-8">
                <label for="nome" class="form-label mt-3">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome do setor" required autofocus value="<?= setValor('nome', $data) ?>" <?= $action != 'new' && $action != 'update' ? 'disabled' : '' ?>>
                <?= setaMsgErrorCampo('nome', $errors) ?>
            </div>

            <div class="col-12 col-md-4 mt-3">
                <?= comboboxStatus(setValor('statusRegistro', $data), $action) ?>
                <?= setaMsgErrorCampo('statusRegistro', $errors) ?>

            </div>

            <div class="col-12 col-md-12 mt-4">
                <label for="funcionarios" class="form-label">Responsavel pelo setor</label>
                <select name="funcionarios" id="funcionarios" class="form-control" 
                <?= $action != 'new' && $action != 'update' ? 'disabled' : '' ?>
                <?= !empty($aFuncionario) ? 'required' : '' ?>   
                >
                    <option value="">...</option> 
                    <?php foreach ($aFuncionario as $value): ?>
                        <option value="<?= $value['id'] ?>" <?= $value['id'] == setValor('responsavel', $data) ? 'selected' : '' ?>>
                            <?= $value['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= setaMsgErrorCampo('funcionarios', $errors) ?>

            </div>
        </div>

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
