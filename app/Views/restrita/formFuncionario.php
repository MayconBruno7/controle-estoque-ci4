<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<main class="container mt-5">


    <div class="container" style="margin-top: 130px;">
        <?= exibeTitulo("Funcionario", ['acao' => $action]) ?>
    </div>

    <!-- pega se é insert, delete ou update a partir do metodo get assim mandando para a página correspondente -->
    <?= form_open(base_url() . 'Funcionario/' . ($action == "delete" ? "delete" : "store"), ['enctype' => 'multipart/form-data']) ?>

        <div class="row">

            <div class="col-12 col-md-6 form-group">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome do funcionario" required value="<?= setValor('nome', $data) ?>" <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                <?= setaMsgErrorCampo('nome', $errors) ?>
            </div>

            <div class="col-12 col-md-6 form-group">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Cpf do funcionario" maxlength="14" required value="<?= formatarCPF(setValor('cpf', $data)) ?>" oninput="formatarCPF(this)" <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                <?= setaMsgErrorCampo('cpf', $errors) ?>
            </div>

            <div class="col-12 col-md-6 form-group">
                <label for="statusRegistro" class="form-label">Estado do registro</label>
                <select name="statusRegistro" id="statusRegistro" class="form-control" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                    <option value="" <?= setValor('statusRegistro', $data) == "" ? "SELECTED" : "" ?>>...</option>
                    <option value="1" <?= setValor('statusRegistro', $data) == "1" ? "SELECTED" : "" ?>>Ativo</option>
                    <option value="2" <?= setValor('statusRegistro', $data) == "2" ? "SELECTED" : "" ?>>Inativo</option>
                </select>
                <?= setaMsgErrorCampo('statusRegistro', $errors) ?>
            </div>

            <div class="col-12 col-md-6 form-group">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone" maxlength="14" required value="<?= formatarTelefone(setValor('telefone', $data)) ?>" oninput="formatarTelefone(this)" <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                <?= setaMsgErrorCampo('telefone', $errors) ?>
            </div>

            <div class="col-12 col-md-4 form-group">
                <label for="setor" class="form-label">Setor</label>
                <select name="setor" id="setor" class="form-control" <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?> <?= !empty($aSetor) ? 'required' : '' ?>>
                    <option value="">...</option>
                    <?php foreach ($aSetor as $setor): ?>
                        <option value="<?= $setor['id'] ?>" <?= setValor('setor', $data) == $setor['id'] ? 'selected' : '' ?>><?= $setor['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?= setaMsgErrorCampo('setor', $errors) ?>
            </div>

            <div class="col-12 col-md-4 form-group">
                <label for="cargo" class="form-label">Cargo</label>
                <select name="cargo" id="cargo" class="form-control" <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?> <?= !empty($aCargo) ? 'required' : '' ?>>
                    <option value="">...</option>
                    <?php foreach ($aCargo as $cargo): ?>
                        <option value="<?= $cargo['id'] ?>" <?= setValor('cargo', $data) == $cargo['id'] ? 'selected' : '' ?>><?= $cargo['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?= setaMsgErrorCampo('cargo', $errors) ?>
            </div>

            <div class="col-12 col-md-4 form-group">
                <label for="salario" class="form-label">Salário</label>
                <input type="text" class="form-control" name="salario" id="salario" placeholder="Salário R$" required value="<?= formatarSalario(setValor('salario', $data)) ?>" oninput="formatarSalario(this)" <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                <?= setaMsgErrorCampo('salario', $errors) ?>
            </div>

            <div class="col-12 mb-3 mt-3">
                <label for="anexos" class="form-label">Imagem</label>
                <input class="form-control" type="file" id="imagem" name="imagem">
            </div>

            <?php if (!empty(setValor('imagem', $data))): ?>
            <div class="mb-3 col-12">
                <h5>Imagem</h5>
                <img src="<?= base_url('writable/uploads/funcionarios/' . rawurlencode(setValor('imagem', $data))) ?>" class="img-thumbnail" height="150" width="140"/>
            </div>
            <?php endif; ?>

            <input type="hidden" name="id" value="<?= setValor('id', $data) ?>">
            <input type="hidden" name="action" value="<?= $action ?>">
            <input type="hidden" name="nomeImagem" value="<?= setValor('imagem', $data) ?>">

            <div class="form-group col-12 mt-5">
                <?php if ($action != "view"): ?>
                    <button type="submit" value="submit" id="btGravar" class="btn btn-primary btn-sm">Gravar</button>
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

    function formatarCPF(campo) {
        // Remove todos os caracteres que não são números
        var cpf = campo.value.replace(/\D/g, '');

        // Adiciona pontos e traços conforme o padrão do CPF
        if (cpf.length > 3) {
            cpf = cpf.substring(0, 3) + "." + cpf.substring(3);
        }
        if (cpf.length > 7) {
            cpf = cpf.substring(0, 7) + "." + cpf.substring(7);
        }
        if (cpf.length > 11) {
            cpf = cpf.substring(0, 11) + "-" + cpf.substring(11);
        }

        // Atualiza o valor do input
        campo.value = cpf;
    }

    function formatarTelefone(input) {
        // Remove todos os caracteres não numéricos
        var telefone = input.value.replace(/\D/g, '');

        // Verifica o tamanho máximo do número de telefone
        var maxLength = 11; // Se quiser permitir mais dígitos, ajuste o valor aqui

        // Formatação do número de telefone
        if (telefone.length <= maxLength) {
            telefone = telefone.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4');
        } else {
            // Caso o número de telefone tenha mais dígitos do que o permitido
            telefone = telefone.slice(0, maxLength);
            telefone = telefone.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4');
        }

        // Atualiza o valor do input com o telefone formatado
        input.value = telefone;
    }

    function formatarSalario(input) {
        // Remove todos os caracteres não numéricos
        var valor = input.value.replace(/\D/g, '');

        // Verifica se o valor não está vazio
        if (valor !== '') {
            // Divide o valor em parte inteira e parte decimal
            var parteInteira = valor.substring(0, valor.length - 2);
            var parteDecimal = valor.substring(valor.length - 2);

            // Adiciona o separador de milhares (ponto)
            parteInteira = parteInteira.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Formata o valor como moeda (R$)
            valor = parteInteira + ',' + parteDecimal;

            // Atualiza o valor do input
            input.value = valor;
        } else {
            // Se o valor estiver vazio, define o valor como vazio
            input.value = '';
        }
    }
</script>


<?= $this->endSection() ?>