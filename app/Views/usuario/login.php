<?= $this->extend('layout/layout_default') ?>

<?= $this->section('conteudo') ?>

<section class="about section-margin  container" style="margin-top: 130px;">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <?= form_open("Login/signIn", ['class' => 'needs-validation', 'novalidate' => '']) ?>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" name="email" tabindex="1" required="" autofocus="" value="<?= isset($_COOKIE['username']) ? $_COOKIE['username'] : '' ?>">
                            <div class="invalid-feedback">
                                Por favor preencha o email.
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-block">
                                <label for="senha" class="control-label">Senha</label>
                                <div class="float-right">
                                    <a href="<?= site_url("Login/solicitaRecuperacaoSenha") ?>" class="text-small">
                                        Esqueceu sua senha?
                                    </a>
                                </div>
                            </div>
                            <input id="senha" type="password" class="form-control" name="senha" tabindex="2" required="" value="<?= isset($_COOKIE['password']) ? $_COOKIE['password'] : '' ?>">
                            <div class="invalid-feedback">
                                Por favor preencha a senha.
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" <?= isset($_COOKIE['username']) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="remember-me">Lembre de mim</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" value="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    <?= form_close() ?>
                </div>
                <div class="col-md-12 form-group">
                    <?= mensagemSucesso() ?>
                    <?= mensagemError() ?>
                </div>
            </div>
            <div class="mt-5 text-muted text-center">
                Não tem uma conta? <a href="<?= site_url("Home/criarConta") ?>">Crie sua conta aqui</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
