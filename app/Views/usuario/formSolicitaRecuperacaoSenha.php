<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-center">
                <h1 style="color: #384aeb;">Solicita Recuperação de Senha</h1>
            </div>
        </div>
    </div>
</section>

<section class="section-margin section-login">

    <div class="mt-5 col-12" style="display: flex; justify-content: space-around; align-items: center;">
        <div class="">
            <form class="form-contact contact_form" action="<?= base_url() . "Login/gerarLinkRecuperaSenha" ?>" method="POST" id="contactForm" novalidate="novalidate">
                <div class="row">

                    <div class="col-sm-12 header-login mb-4">
                        <h6 class="intro-title header-login-title p-2 font-weight-bold">Informe seu e-mail</h6>
                    </div>        
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input class="form-control" name="email" id="email" 
                                    type="text" 
                                    placeholder="e-mail"
                                    required>
                        </div>
                    </div>
                </div>

                <?php

                if (session()->get('msgError')) {
                    ?>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= session()->destroy('msgError') ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="form-group mt-3 controls">
                    <button type="submit" class="btn btn-outline-primary btnCustomAzul">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>