<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/usuario.js"></script>

<div class="container" style="margin-top: 130px;">
    <?= exibeTitulo("Usuario", ['acao' => $action]) ?>
</div>

<main class="container mt-5">

    <?= form_open(base_url() . 'Usuario/' . ($action == "delete" ? "delete" : "store")) ?>

        <div class="row">

            <div class="form-group col-12 col-md-8">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" maxlength="50" 
                       value="<?= setValor('nome', $data) ?>" 
                       required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?> autofocus placeholder="Nome completo do usuário">
                <?= setaMsgErrorCampo('nome', $errors) ?>
            </div>

            <div class="form-group col-12 col-md-4">
                <label for="statusRegistro" class="form-label">Status</label>
                <select name="statusRegistro" id="statusRegistro" class="form-control" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                    <option value="" <?= setValor('statusRegistro', $data) == "" ? "selected" : "" ?>>.....</option>
                    <option value="1" <?= setValor('statusRegistro', $data) == "1" ? "selected" : "" ?>>Ativo</option>
                    <option value="2" <?= setValor('statusRegistro', $data) == "2" ? "selected" : "" ?>>Inativo</option>
                </select>
                <?= setaMsgErrorCampo('statusRegistro', $errors) ?>
            </div>

            <div class="form-group col-12 col-md-8">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" name="email" id="email" class="form-control" maxlength="100" 
                       value="<?= setValor('email', $data) ?>" 
                       required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?> placeholder="E-mail: seu-nome@dominio.com">
                <?= setaMsgErrorCampo('email', $errors) ?>
            </div>

            <div class="form-group col-12 col-md-4">
                <label for="nivel" class="form-label">Nível</label>
                <select name="nivel" id="nivel" class="form-control" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                    <option value="" <?= setValor('nivel', $data) == "" ? "selected" : "" ?>>.....</option>
                    <option value="1" <?= setValor('nivel', $data) == "1" ? "selected" : "" ?>>Administrador</option>
                    <option value="11" <?= setValor('nivel', $data) == "11" ? "selected" : "" ?>>Usuário</option>
                </select>
                <?= setaMsgErrorCampo('nivel', $errors) ?>
            </div>

            <div class="col-12">
                <label for="funcionarios" class="form-label">Funcionários</label>
                <select name="funcionarios" id="funcionarios" class="form-control" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                    <option value="">...</option>
                    <?php foreach($aFuncionario as $funcionario) : ?>
                        <option value="<?= $funcionario['id'] ?>" <?= setValor('id_funcionario', $data) == $funcionario['id'] ? 'selected' : '' ?>>
                            <?= $funcionario['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= setaMsgErrorCampo('funcionarios', $errors) ?>
            </div>

            <div class="form-group col-12 col-md-6 mt-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" maxlength="250" 
                       value="" 
                    placeholder="Informe uma nova senha caso deseje alterar"
                    <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>
                       onkeyup="checa_segur_senha('senha', 'msgSenha', 'btGravar');">
                <div id="msgSenha" class="msgNivel_senha"></div>
                <?= setaMsgErrorCampo('senha', $errors) ?>
            </div>

            <div class="form-group col-12 col-md-6 mt-3">
                <label for="confSenha" class="form-label">Confere a senha</label>
                <input type="password" name="confSenha" id="confSenha" class="form-control" maxlength="250" 
                       value="" 
                       placeholder="Confirme a senha digitada"
                       <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>
                       onkeyup="checa_segur_senha('confSenha', 'msgConfSenha', 'btGravar');">
                <div id="msgConfSenha" class="msgNivel_senha"></div>
                <?= setaMsgErrorCampo('confSenha', $errors) ?>
            </div>

            <input type="hidden" name="id" value="<?= setValor('id', $data) ?>">

            <div class="form-group col-12 col-md-4 mt-3">
                <?php if ($action != "view"): ?>
                    <button type="submit" value="submit" id="btGravar" class="btn btn-primary">Gravar</button>
                <?php endif; ?>
                
            </div>

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