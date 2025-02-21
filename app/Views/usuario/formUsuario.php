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
                <?= comboboxStatus(setValor('statusRegistro', $data), $action) ?>
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
                <select name="funcionarios" id="funcionarios" class="form-control" <?= !empty($aFuncionario) ? 'required ' : '' ?>  <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                    <option value="">...</option>
                    <?php foreach($aFuncionario as $funcionario) : ?>
                        <option value="<?= $funcionario['id'] ?>" <?= setValor('id_funcionario', $data) == $funcionario['id'] ? 'selected' : '' ?>>
                            <?= $funcionario['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= setaMsgErrorCampo('funcionarios', $errors) ?>
            </div>

            <?php if ($action != "update"): ?>
                <div class="form-group col-12 col-md-6 mt-3">
                    <label for="senha" class="form-label">Nova senha</label>
                    <input type="password" name="senha" id="senha" class="form-control toggle-password" maxlength="250" 
                        value="<?= setValor('senha', $data) ?>"  
                        placeholder="Informe uma nova senha caso deseje alterar"
                        <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>
                        onkeyup="checa_segur_senha('senha', 'msgSenha', 'btnGravar');">
                    <div id="msgSenha" class="msgNivel_senha"></div>
                    <?= setaMsgErrorCampo('senha', $errors) ?>
                </div>

                <div class="form-group col-12 col-md-6 mt-3">
                    <label for="confSenha" class="form-label">Confirme a senha</label>
                    <input type="password" name="confSenha" id="confSenha" class="form-control toggle-confPassword" maxlength="250" 
                        value="<?= setValor('confSenha', $data) ?>"  
                        placeholder="Confirme a senha digitada"
                        <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>
                        onkeyup="checa_segur_senha('confSenha', 'msgConfSenha', 'btnGravar');">
                    <div id="msgConfSenha" class="msgNivel_senha"></div>
                    <?= setaMsgErrorCampo('confSenha', $errors) ?>
                </div>            

                <div class="col-12 col-md-6">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" id="mostrar-senha" class="custom-control-input" onclick="togglePassword('senha')">
                        <span class="custom-control-label">Mostrar senha</span>
                    </label>
                </div>

                <div class="col-12 col-md-6">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" id="mostrar-confSenha" class="custom-control-input" onclick="togglePassword('confSenha')">
                        <span class="custom-control-label">Mostrar confere senha</span>
                    </label>
                </div>
            <?php endif; ?>

            <input type="hidden" name="id" value="<?= setValor('id', $data) ?>">
            <input type="hidden" name="action" value="<?= $action ?>">

            <div class="form-group col-12 col-md-4 mt-3">
                <?php if ($action != "view"): ?>
                    <button type="submit" value="submit" id="btnGravar" class="btn btn-primary">Gravar</button>
                <?php endif; ?>
            </div>

            <?php if ($action == "view"): ?>
                <button onclick="goBack()" class="btn btn-secondary">Voltar</button>
            <?php endif; ?>
        
        </div>    
    <?= form_close() ?>

    <script>
        
        function goBack() {
            window.history.go(-1);
        }

        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const isPasswordVisible = passwordInput.type === "text";

            passwordInput.type = isPasswordVisible ? "password" : "text";
        }
    </script>

<?= $this->endSection() ?>