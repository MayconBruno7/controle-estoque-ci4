<?php

    $this->extend('layout/layout_default');  

    $this->section('conteudo');

    $nomeCargo = 'Nenhum cargo encontrado'; 

?>

<div class="container">
    <div class="card-body" style="margin-top: 130px;">
        <div class="col-12">
            <div class="card author-box">
                <div class="card-body">
                    <div class="author-box-center">
                        <?php if ((session()->get('id_funcionario')) && (session()->get('usuarioImagem'))) : ?>
                            <img alt="image" src="<?= base_url('writable/uploads/funcionarios/' . session()->get('usuarioImagem')) ?>" width="200px" height="200px" class="rounded-circle">
                        <?php else : ?>
                            <img alt="image" class="rounded-circle" src="<?= base_url() . 'assets/img/users/person.svg' ?>" width="40px" height="40px">
                        <?php endif; ?>
                        
                        <div class="clearfix"></div>
                        <div class="author-box-name">
                            <a href="#"><?= $aFuncionario['nome'] ?></a>
                        </div>
                        <div class="author-box-job">
                            <?= $aFuncionario['nome_cargo'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Detalhes pessoais</h4>
                </div>
                <div class="card-body">
                    <div class="py-4">
                        <p class="clearfix">
                            <span class="float-left">
                                <i class="far fa-address-card"> CPF</i>
                            </span>
                            <span class="float-right text-muted">
                                <?= formatarCPF($aFuncionario['cpf']) ?>
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                <i class="fas fa-phone-volume"> Telefone</i>
                            </span>
                            <span class="float-right text-muted">
                                <?= formatarTelefone($aFuncionario['telefone']) ?>
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                <i class="far fa-envelope"> E-mail</i>
                            </span>
                            <span class="float-right text-muted">
                                <?= $aUsuario[0]['email'] ?>
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                <i class="far fa-money-bill-alt"> Salário</i>
                            </span>
                            <span class="float-right text-muted">
                                R$ <?= number_format($aFuncionario['salario'], 2, ',', '.') ?>
                            </span> 			
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>