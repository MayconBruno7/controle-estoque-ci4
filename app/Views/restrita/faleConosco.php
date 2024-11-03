<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<div class="row mt-5">
    <div class="col-12 mt-5 text-center">
        <h2 class="">Fale Conosco</h2>
    </div>
</div>

<div class="row text-center align-itens-center">
    <div class="col-12">
        <?= mensagemError() ?>
    </div>

    <div class="col-12 mt-3">
        <?= mensagemSucesso() ?>
    </div>
</div>

<main class="container mt-5 d-flex justify-content-center align-items-center">
    <form class="g-3" action="<?= base_url() ?>FaleConosco/enviarEmail" method="POST">

        <div class="row">

            <div class="col-12 col-md-12 mt-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome"
                       placeholder="Seu nome" required autofocus>
            </div>

            <div class="col-12 col-md-9 mt-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" class="form-control" name="email" id="email" 
                       placeholder="Seu e-mail" required>
            </div>

            <div class="col-12 col-md-3 mt-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="telefone" 
                       placeholder="Seu telefone" required>
            </div>

            <div class="col-12 mt-3">
                <label for="assunto" class="form-label">Assunto</label>
                <input type="text" class="form-control" name="assunto" id="assunto" 
                       placeholder="Assunto a ser tratado" required>
            </div>

            <div class="col-12 mt-3">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea class="form-control" rows="10" name="mensagem" id="mensagem" 
                          placeholder="Descreva mais sobre o assunto que deseja tratar conosoco."></textarea>
            </div>

            <div class="col-auto mt-5 mb-3">
                <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
            </div>
        </div>
    </form>
</main>

<?= $this->endSection() ?>

<script src="<?= base_url() ?>assets/ckeditor5/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#mensagem'))
        .catch( error => {
            console.error(error);
        });
</script>
