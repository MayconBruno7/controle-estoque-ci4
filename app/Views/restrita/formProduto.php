<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>



<div class="container">
    
    <div class="container" style="margin-top: 130px;">
        <?= exibeTitulo("Produto", ['acao' => $action]) ?>
    </div>

    <?php

        if (isset($action) && $action != 'insert') {
            ?>
            <div class="row">
                <div class="col-12 d-flex justify-content-start">
                    <a href="<?= base_url() ?>HistoricoProdutoMovimentacao/index/<?= setValor('id', $data) ?>/<?= $action ?>" class="btn btn-outline-primary btn-sm mt-3 mb-3 m-0 styleButton" title="Visualizar">Visualizar Histórico de Movimentações</a>
                </div>
            </div>
        <?php
        }
    ?>

    <?= form_open(base_url() . 'Produto/' . ($action == "delete" ? "delete" : "store")) ?>

    <div class="row">

        <div class="col-12 col-md-8">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome do item" required autofocus value="<?= setValor('nome', $data) ?>" <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
            <?= setaMsgErrorCampo('nome', $errors) ?>
        </div>

        <div class="col-12 col-md-4">
            <label for="quantidade" class="form-label">Quantidade</label>
            <?php 
            $quantidade = setValor('quantidade', $data);
            $quantidadeFormatada = is_numeric($quantidade) ? number_format($quantidade, 2, ",", ".") : '0,00'; // Formatação correta
            ?>
            <input type="text" class="form-control" name="qtd_item" id="quantidade" value="<?= $quantidadeFormatada ?>" disabled>
            <input type="hidden" name="quantidade" id="hidden" value="<?= $quantidade ?>">
            <?= setaMsgErrorCampo('quantidade', $errors) ?>
        </div>

        <div class="col-12 col-md-6 mt-3">
            <label for="fornecedor_id" class="form-label">Fornecedor</label>
            <select class="form-control" name="fornecedor_id" id="fornecedor_id"  
            <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>
            <?= !empty($aFornecedor) ? 'required' : '' ?>>                
                <option value="" <?= setValor('fornecedor') == ""  ? "SELECTED": "" ?>>...</option>
                <?php foreach ($aFornecedor as $value) : ?>
                    <option value="<?= $value['id'] ?>" <?= setValor('fornecedor', $data) == $value['id'] ? "SELECTED": "" ?>><?= $value['nome'] ?></option>
                <?php endforeach; ?>
            </select>
            <?= setaMsgErrorCampo('fornecedor_id', $errors) ?>
        </div>

        <div class="col-12 col-md-3 mt-3">
            <label for="statusRegistro" class="form-label">Status</label>
            <select class="form-control" name="statusRegistro" id="statusRegistro" required <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
                <option value=""  <?= setValor('statusRegistro', $data) == ""  ? "SELECTED": "" ?>>...</option>
                <option value="1" <?= setValor('statusRegistro', $data) == "1" ? "SELECTED": "" ?>>Ativo</option>
                <option value="2" <?= setValor('statusRegistro', $data) == "2" ? "SELECTED": "" ?>>Inativo</option>
            </select>
            <?= setaMsgErrorCampo('statusRegistro', $errors) ?>
        </div>

        <div class="col-12 col-md-3 mt-3">
            <label for="condicao" class="form-label">Estado do item</label>
            <select name="condicao" id="condicao" class="form-control" required <?= $action == 'delete' || $action == 'view' ? 'disabled' : '' ?>>
                <option value=""  <?= setValor('condicao', $data) == "" ? "selected" : ""  ?>>...</option>
                <option value="1" <?= setValor('condicao', $data) == 1  ? "selected" : ""  ?>>Novo</option>
                <option value="2" <?= setValor('condicao', $data) == 2  ? "selected" : ""  ?>>Usado</option>
            </select>
            <?= setaMsgErrorCampo('condicao', $errors) ?>
        </div>

        <div class="col-12 mt-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição do item" <?= $action == 'delete' || $action == 'view' ? 'disabled' : '' ?>><?= setValor('descricao', $data) ?></textarea>
            <?= setaMsgErrorCampo('descricao', $errors) ?>
        </div>

        <?php if ($action == 'view' || $action == 'delete' || $action == 'update') { ?>
        <div class="col-12 col-md-6 mt-3">
            <label for="dataMod" class="form-label">Data da última modificação</label>
            <input type="text" class="form-control" name="dataMod" id="dataMod" value="<?= setValor('dataMod', $data) ?>" disabled>
            <input type="hidden" class="form-control" name="dataMod" id="dataMod" value="<?= setValor('dataMod', $data) ?>">
        </div>
        <?php } ?>

        <?php if ($action != 'insert' && $action != 'delete' && $action != 'view') : ?>
        <div class="col-12 col-md-6 mt-3">
            <label for="historico" class="form-label">Histórico de Alterações</label>
            <input type="date" class="form-control" name="historico" id="search_historico" placeholder="Data do histórico" autofocus value="" max="<?= date('Y-m-d') ?>" <?= $action == 'view' || $action == 'delete' ? 'disabled' : '' ?>>
            <select id="id_produto" class="form-control" style="display:none;">
                <option value="" selected disabled>Escolha a data</option>
            </select>
        </div>
        <?php endif; ?>

        <input type="hidden" name="id" id="id" value="<?= setValor('id', $data) ?>">

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


</div>


<script src="<?= base_url() ?>assets/ckeditor5/ckeditor.js"></script>

<script type="text/javascript">

    function goBack() {
        window.history.go(-1);
    }

    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
            .create(document.querySelector('#descricao'), {})
            .then(editor => { // Definindo o editor CKEditor aqui
                document.getElementById('historico').addEventListener('change', function() {
                    var option = this.options[this.selectedIndex];
                    
                    // Definindo os outros valores conforme necessário
                    document.getElementById('nome').value = option.getAttribute('data-nome');
                    document.getElementById('quantidade').value = option.getAttribute('data-quantidade');
                    // Definindo o texto do setor e fornecedor nos elementos
                    document.getElementById('fornecedor_id').value = option.getAttribute('data-fornecedor');
                    document.getElementById('statusRegistro').value = option.getAttribute('data-status');
                    document.getElementById('condicao').value = option.getAttribute('data-statusitem');
                    editor.setData(option.getAttribute('data-descricao')); 
                    console.log(option);
                });
            })
            .catch(error => {
                console.error(error);
            });
    });

    // busca historico a partir da data escolhida
    $(function() {
        $('#search_historico').change(function() {
            var termo = $(this).val().trim();

            if (termo.length > 0) {
                $('.carregando').show();

                $.getJSON('/HistoricoProduto/getHistoricoProduto/' + termo, function(data) {
                    console.log(data);
                    var options = '<option value="" selected disabled>Escolha a data</option>';
                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].id + '" data-nome="' + data[i].nome_produtos + '" data-fornecedor="' + data[i].fornecedor_id + '" data-descricao="' + data[i].descricao_anterior + '" data-quantidade="' + data[i].quantidade_anterior + '" data-status="' + data[i].status_anterior + '" data-statusitem="' + data[i].statusItem_anterior + '">' + (data[i].dataMod != '0000-00-00 00:00:00' ? data[i].dataMod : 'Primeira alteração') + '</option>';
                        }
                    } else {
                        options = '<option value="" selected disabled>Nenhum histórico encontrado</option>';
                    }
                    $('#id_produto').html(options).show();

                    // Atualizar o formulário com os dados do primeiro item retornado
                    if (data.length > 0) {
                        var firstItem = data[0];
                        $('#nome').val(firstItem.nome_produtos);
                        $('#quantidade').val(firstItem.quantidade_anterior);
                        $('#fornecedor_id').val(firstItem.fornecedor_id);
                        $('#statusRegistro').val(firstItem.status_anterior);
                        $('#condicao').val(firstItem.statusItem_anterior);
                        $('#descricao').val(firstItem.descricao_anterior);
                    }
                })
                .fail(function() {
                    console.error("Erro ao carregar histórico.");
                    $('#id_produto').html('<option value="" selected disabled>Erro ao carregar históricos</option>').show();
                })
                .always(function() {
                    $('.carregando').hide();
                });
            } else {
                $('#id_produto').html('<option value="" selected disabled>Escolha a data</option>').show();
            }
        });

        $('#id_produto').change(function() {
            var selectedOption = $(this).find(':selected');

            // Atualizar o formulário com os dados do item selecionado
            $('#nome').val(selectedOption.data('nome'));
            $('#quantidade').val(selectedOption.data('quantidade'));
            $('#fornecedor_id').val(selectedOption.data('fornecedor'));
            $('#statusRegistro').val(selectedOption.data('status'));
            $('#condicao').val(selectedOption.data('statusitem'));
            $('#descricao').val(selectedOption.data('descricao'));
        });
    });

</script>
<?= $this->endSection() ?>