<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<?php

    $estadoSelecionado = setValor('estado', $data);
    $cidadeSelecionada = setValor('cidade', $data);

?>

<div class="container">

    <div class="container" style="margin-top: 130px;">
        <?= exibeTitulo("Fornecedor", ['acao' => $action]) ?>
    </div>

    <?= form_open(base_url() . 'Fornecedor/' . ($action == "delete" ? "delete" : "store")) ?>

        <div class="container">
            <div class="row">

                <div class="mb-3 col-12 col-md-4">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" name="cnpj" id="cnpj" 
                        maxlength="18" oninput="formatarCNPJ(this)" placeholder="Informe o CNPJ"
                        value="<?= formatarCNPJInput(setValor('cnpj', $data)) ?>"
                        autofocus <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <?= setaMsgErrorCampo('cnpj', $errors) ?>
                </div>

                <div class="mb-3 col-12 col-md-4">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome" id="nome" 
                        maxlength="50" placeholder="Informe nome do fornecedor"
                        value="<?= setValor('nome', $data) ?>"
                        <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <?= setaMsgErrorCampo('nome', $errors) ?>
                </div>

                <div class="mb-3 col-12 col-md-4">
                    <label for="statusRegistro" class="form-label">Status</label>
                    <select class="form-control" name="statusRegistro" id="statusRegistro" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <option value=""  <?= setValor('statusRegistro', $data) == ""  ? "SELECTED": "" ?>>...</option>
                        <option value="1" <?= setValor('statusRegistro', $data) == "1" ? "SELECTED": "" ?>>Ativo</option>
                        <option value="2" <?= setValor('statusRegistro', $data) == "2" ? "SELECTED": "" ?>>Inativo</option>
                    </select>
                    <?= setaMsgErrorCampo('statusRegistro', $errors) ?>
                </div>

                <div class="mb-3 col-12 col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" name="estado" id="estado" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <option value="" selected >...</option>
                        <?php foreach ($aEstado as $value): ?>
                            <option value="<?= $value['id'] ?>" <?= $estadoSelecionado == $value['id'] ? "selected" : "" ?>><?= $value['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= setaMsgErrorCampo('estado', $errors) ?>
                </div>

                <div class="mb-3 col-12 col-md-6">
                    <label for="cidade" class="form-label">Cidade</label>
                    <select class="form-control" name="cidade" id="cidade" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <?php if (empty($cidadeSelecionada)) : ?>
                            <option value="" selected disabled>Escolha um estado</option>
                        <?php endif; ?>

                        <?php if (!empty($cidadeSelecionada)) : ?>
                            <?php foreach ($aCidade as $value): ?>
                            <option value="<?= $value['id'] ?>" <?= $cidadeSelecionada == $value['id'] ? "selected" : "" ?>><?= $value['nome'] ?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?= setaMsgErrorCampo('cidade', $errors) ?>
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" name="bairro" id="bairro" 
                        maxlength="50" placeholder="Informe o bairro"
                        value="<?= setValor('bairro', $data) ?>"
                        <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <?= setaMsgErrorCampo('bairro', $errors) ?>
                </div>

                <div class="mb-3 col-12 col-md-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" name="endereco" id="endereco" 
                        maxlength="50" placeholder="Informe o endereço"
                        value="<?= setValor('endereco', $data) ?>"
                        <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <?= setaMsgErrorCampo('endereco', $errors) ?>
                </div>

                <div class="mb-3 col-12 col-md-2">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" name="numero" id="numero" 
                        maxlength="50" placeholder="Informe o número"
                        value="<?= setValor('numero', $data) ?>"
                        <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <?= setaMsgErrorCampo('numero', $errors) ?>
                </div>

                <div class="mb-3 col-12 col-md-2">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" name="telefone" id="telefone" 
                        maxlength="50" placeholder="Informe o telefone"
                        value="<?= formatarTelefone(setValor('telefone', $data)) ?>"
                        oninput="formatarTelefone(this)"
                        <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                        <?= setaMsgErrorCampo('telefone', $errors) ?>
                </div>

                <input type="hidden" name="id" id="id" value="<?= setValor('id', $data) ?>">
                <input type="hidden" name="action" id="action" value="<?= setValor($action) ?>">

                <div class="form-group col-12 mt-5">
                    <?php if ($action != "view"): ?>
                        <button type="submit" value="submit" id="btGravar" class="btn btn-primary btn-sm">Gravar</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?= form_close() ?>

    <?php if ($action == "view"): ?>
        <button onclick="goBack()" class="btn btn-secondary">Voltar</button>
    <?php endif; ?>

</div>

<script>

    function goBack() {
        window.history.go(-1);
    }

    function formatarCNPJ(campo) {
        // Remove qualquer caracter especial, exceto números
        let cnpj = campo.value.replace(/[^\d]/g, '');

        // Formata o CNPJ (XX.XXX.XXX/XXXX-XX)
        if (cnpj.length > 2 && cnpj.length <= 5) {
            cnpj = cnpj.replace(/(\d{2})(\d)/, "$1.$2");
        } else if (cnpj.length > 5 && cnpj.length <= 8) {
            cnpj = cnpj.replace(/(\d{2})(\d{3})(\d)/, "$1.$2.$3");
        } else if (cnpj.length > 8 && cnpj.length <= 12) {
            cnpj = cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d)/, "$1.$2.$3/$4");
        } else if (cnpj.length > 12 && cnpj.length <= 14) {
            cnpj = cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d)/, "$1.$2.$3/$4-$5");
        } else if (cnpj.length > 14) {
            cnpj = cnpj.substring(0, 14);
        }

        campo.value = cnpj;
    }

    function formatarCNPJinput(cnpjInput) {
        // Remove tudo o que não é dígito
        let cnpj = cnpjInput.value.replace(/\D/g, '');

        // Insere os caracteres especiais
        cnpj = cnpj.replace(/^(\d{2})(\d)/, '$1.$2');
        cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        cnpj = cnpj.replace(/\.(\d{3})(\d)/, '.$1/$2');
        cnpj = cnpj.replace(/(\d{4})(\d)/, '$1-$2');

        // Atualiza o valor do input
        cnpjInput.value = cnpj;
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

    function pegaPrimeiroTelefone(phoneString) {
        // Expressão regular para encontrar o primeiro número de telefone
        const regex = /\(\d{2}\) \d{4,5}-\d{4}/;
        const match = phoneString.match(regex);

        if (match) {
            return match[0];
        } else {
            return '';
        }
    }

    document.getElementById('cnpj').addEventListener('input', function() {
        let campoCNPJ = document.getElementById('cnpj');

        // Chama a função para formatar o CNPJ
        formatarCNPJ(campoCNPJ);

        // Remove todos os caracteres que não são dígitos para a chamada API
        let cnpjParaAPI = campoCNPJ.value.replace(/\D/g, '');

        if (cnpjParaAPI.length === 14) {
            fetch('<?= base_url() ?>Fornecedor/requireAPI/' + cnpjParaAPI)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Erro:', data.error);
                    } else {
                        document.getElementById('nome').value = data.fantasia || data.nome || '';
                        document.getElementById('estado').value = data.uf || '';
                        document.getElementById('cidade').value = data.municipio || '';
                        document.getElementById('bairro').value = data.bairro || '';
                        document.getElementById('endereco').value = data.logradouro || '';
                        document.getElementById('numero').value = data.numero || '';
                        document.getElementById('telefone').value = pegaPrimeiroTelefone(data.telefone) || '';
                    }
                })
                .catch(error => {
                    console.error('Erro na solicitação:', error);
                });
        } else {
            // Limpar os campos se o CNPJ não estiver completo
            document.getElementById('nome').value = '';
            document.getElementById('estado').value = '';
            document.getElementById('cidade').value = '';
            document.getElementById('bairro').value = '';
            document.getElementById('endereco').value = '';
            document.getElementById('numero').value = '';
            document.getElementById('telefone').value = '';
        }
    });

    $(function() {
        $('#estado').change(function() {
            if ($(this).val()) {
                $('#cidade').hide();
                $('.carregando').show();

                $.getJSON('/Fornecedor/getCidadeComboBox/' + $(this).val(), 
                    function(data) {
                        var options = '<option value="" selected disabled>Escolha uma cidade</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
                        }
                        $('#cidade').html(options);
                        $('#cidade').show();
                    }
                ).fail(function() {
                    console.error("Erro ao carregar cidades.");
                }).always(function() {
                    $('.carregando').hide();
                });
            }
        });
    });

</script>

<?= $this->endSection() ?>