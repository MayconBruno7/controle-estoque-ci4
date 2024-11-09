<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Controle de estoque</title>

    <link rel="stylesheet" href="<?= base_url("assets/bootstrap/css/bootstrap.min.css") ?>">
    <link rel="icon" href="<?= base_url("assets/img/brasao-pmrl-icon.jpeg") ?>" type="image/jpeg">

    <link rel="stylesheet" href="<?= base_url("assets/css/app.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/bundles/datatables/datatables.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css") ?>">

    <link rel="stylesheet" href="<?= base_url("assets/css/app.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/style.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/components.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/custom.css") ?>">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="<?= base_url("assets/js/jquery-3.3.1.js") ?>"></script>
    <script src="<?= base_url("assets/bootstrap/js/bootstrap.min.js") ?>"></script>

</head>

<body class="sidebar-gone sidebar-mini">

<?php if (session()->getFlashdata('exibirModalEstoque')): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            mensagemModal.innerHTML = "Verifique a quantidade dos itens em estoque que foram citados no email enviado para o administrador principal!<br>";

                // Atualizar o tempo restante a cada segundo
                const intervaloAtualizacao = setInterval(function() {
                    const agora = new Date().getTime();
                    const tempoRestante = Math.max(intervalo - (agora - ultimaVerificacao), 0); // Garantir que tempoRestante não seja negativo

                    // Substituir a mensagem de tempo restante
                    mensagemModal.innerHTML = "Verifique a quantidade dos itens em estoque que foram citados no email enviado para o administrador principal!<br>";
                    mensagemModal.innerHTML += "Tempo restante para a próxima notificação de estoque: " + formatarTempo(tempoRestante);

                    // Parar o intervalo quando o tempo restante for 0 ou menor
                    if (tempoRestante <= 0) {
                        clearInterval(intervaloAtualizacao);
                        mensagemModal.innerHTML = "A próxima verificação será realizada em breve!";
                    }
                }, 1000);
            exibirModal("Notificação de estoque", mensagemModal);
        });
    </script>
    <?php session()->remove("exibirModalEstoque"); // Limpa a variável de sessão após o uso ?>
<?php endif; ?>

<?php if (session()->getFlashdata("exibeModalNotificacaoEstoque")): ?>
    <script>
        menssageModal = "";
        document.addEventListener("DOMContentLoaded", function() {
            menssageModal = "Sem itens abaixo do limite de alerta em estoque.";

            exibirModal("Notificação de estoque", menssageModal);
        });
    </script>
    <?php session()->remove("exibeModalNotificacaoEstoque"); // Limpa a variável de sessão após o uso ?>
<?php endif; ?>

<?php if (session()->getFlashdata("sucessoUsuarioAdm") || session()->getFlashdata("erroUsuarioAdm")): ?>
    <script>
        let mensagemModal = `<?php
            echo session()->getFlashdata('sucessoUsuarioAdm') ?: session()->getFlashdata('erroUsuarioAdm');
        ?>`;
        
        document.addEventListener("DOMContentLoaded", function() {
            if (mensagemModal) {
                exibirModal("Alteração do email de administrador", mensagemModal);
            }
        });
    </script>
    <?php session()->remove("sucessoUsuarioAdm"); // Limpa a variável de sessão após o uso ?>
    <?php session()->remove("erroUsuarioAdm"); // Limpa a variável de sessão após o uso ?>
<?php endif; ?>

<div class="modal fade" id="modalGlobal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="mensagemModal"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="loader"></div>
<div class="settingSidebar" id="settingSidebar">

    <a href="javascript:void(0)" class="settingPanelToggle"> 
        <i class="fa fa-spin fa-cog"></i>
    </a>

    <div class="settingSidebar-body ps-container ps-theme-default">
        <div class=" fade show active">
            <div class="setting-panel-header">
                Painel de configurações
            </div>

            <?php if (session()->get('usuarioNivel') == 1): ?>
            <!-- Formulário -->
            <?= form_open(base_url() . 'Configuracoes/store') ?>
            <div class="container">
                <div class="row">
                    <div class="mt-3 col-12">
                        <label for="email" class="form-label">
                            Email administrador 
                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Notificações de estoque são enviadas para esse e-mail.">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control" name="email" id="email" maxlength="50" placeholder="Informe o email do administrador" value="">
                    </div>
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="chave" id="chave" value="">
                    <input type="hidden" name="descricao" id="descricao" value="">
                </div>
            </div>

            <div class="form-group col-12 mt-2">
                <button type="submit" value="submit" id="btGravar" class="btn btn-primary btn-sm">Gravar</button>
            </div>
            <?= form_close() ?>

            <script>
               document.addEventListener('DOMContentLoaded', function() {
                    // Seleciona a div específica que será observada
                    const settingSidebar = document.getElementById('settingSidebar');

                    if (settingSidebar) {
                        // Cria um observador de mudanças de atributos
                        const observer = new MutationObserver((mutationsList) => {
                            for (let mutation of mutationsList) {
                                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                                    // Verifica se a classe 'showSettingPanel' foi adicionada
                                    if (settingSidebar.classList.contains('showSettingPanel')) {
                                        // console.log('A classe showSettingPanel foi adicionada!');

                                        // Faz a requisição AJAX para buscar o emailAdm
                                        fetch('<?= base_url('Configuracoes/getInfoEmailAdm') ?>', {
                                            method: 'GET' // Ajuste conforme necessário
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            // console.log(data);
                                            // Atualiza o campo de email no formulário
                                            document.getElementById('id').value = data[0].id;
                                            document.getElementById('email').value = data[0].valor;
                                            document.getElementById('chave').value = data[0].chave;
                                            document.getElementById('descricao').value = data[0].descricao;
                                        })
                                        .catch(error => {
                                            console.error('Erro ao recuperar email:', error);
                                        });
                                    }
                                }
                            }
                        });

                        // Configura o observador para monitorar mudanças de atributos
                        observer.observe(settingSidebar, { attributes: true });
                    }
                });

            </script>
            <?php endif; ?>

            <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                    <label class="m-b-0">
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                               id="mini_sidebar_setting">
                        <span class="custom-switch-indicator"></span>
                        <span class="control-label p-l-10">Mini barra lateral</span>
                    </label>
                </div>
            </div>
        
            <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                    <i class="fas fa-undo"></i> Restaurar padrão
                </a>
            </div>
        </div>
    </div>
</div>

<div id="app">
    <?php if (session()->get('usuarioId') != false): ?>
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar sticky">
            <div class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
                    </li>
                </ul>
            </div>

            <ul class="navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <?php if ((session()->get('id_funcionario')) && (session()->get('usuarioImagem'))) : ?>
                            <img alt="image" class="rounded-circle" src="<?= session()->get('usuarioImagem') != 'person.svg' ? base_url('writable/uploads/funcionarios/' . session()->get('usuarioImagem')) : base_url() . 'assets/img/users/person.svg' ?> " width="40px" height="40px">
                        <?php else : ?>
                            <img alt="image" class="rounded-circle" src="<?= base_url() . 'assets/img/users/person.svg' ?>" width="40px" height="40px">
                        <?php endif; ?>
                        <span class="d-sm-none d-lg-inline-block"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right pullDown">
                        <div class="dropdown-title">Olá, <?= $_SESSION["usuarioLogin"] ?></div>
                        
                        <?php if(session()->get('id_funcionario') != false) : ?>
                        <a href="<?= base_url() ?>Usuario/profile/view/<?= session()->get('usuarioId') ?>" class="dropdown-item has-icon"><i class="fas fa-id-badge"></i>
                            Perfil
                        </a> 
                        <?php endif; ?>
                        <a href="settingSidebar" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                            Configurações
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url("Login/signOut") ?>" class="dropdown-item has-icon text-danger"><i class="fas fa-sign-out-alt"></i>
                            Sair
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="<?= session()->get('usuarioId') ? base_url() . retornaHomeAdminOuHome() : '#' ?>"> <img alt="imagem" src="<?= base_url() ?>assets/img/brasao-pmrl.png" width="70" height="100" class="header-logo" /> 
                </a>
            </div>
            <?php if (session()->get('usuarioId') != false): ?>
            <ul class="sidebar-menu">
                <li class="menu-header">Principal</li>
                <li class="dropdown active">
                    <a href="<?= session()->get('usuarioId') ? base_url() . retornaHomeAdminOuHome() : '#' ?>" class="nav-link"><i data-feather="monitor"></i><span>Painel</span></a>
                </li>
                <?php if (session()->get('usuarioNivel') == 1): ?>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown">
                        <i data-feather="briefcase"></i>
                        <span>Administrador</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/Usuario">Lista de usuários</a></li>
                        <li><a class="nav-link" href="<?= base_url() ?>Funcionario">Lista de funcionários</a></li>
                        <li><a class="nav-link" href="<?= base_url() ?>Cargo">Lista de cargos</a></li>

                        <li><hr class="dropdown-divider"></li>
                        <li class="menu-header">Relatórios</li>
                        <li class="dropdown">
                            <li><a href="<?= base_url() ?>Relatorio/relatorioMovimentacoes" class="nav-link">Movimentações</a></li>
                            <li><a href="<?= base_url() ?>Relatorio/relatorioItensPorFornecedor" class="nav-link">Por fornecedor</a></li>
                        </li>

                        <li><hr class="dropdown-divider"></li>
                        <li class="menu-header">Logs</li>
                        <li class="dropdown">
                            <li><a href="<?= base_url() ?>Log" class="nav-link">Logs do sistema</a></li>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <li class="menu-header">Páginas</li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Páginas</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="<?= base_url() ?>Produto">Estoque</a></li>
                        <li><a class="nav-link" href="<?= base_url() ?>Setor">Setor</a></li>
                        <li><a class="nav-link" href="<?= base_url() ?>Fornecedor">Fornecedores</a></li>
                        <li><a class="nav-link" href="<?= base_url() ?>Movimentacao">Movimentações</a></li>
                        <li><a class="nav-link" href="<?= base_url() ?>FaleConosco/formularioEmail">Suporte técnico</a></li>
                        <li><a class="nav-link" href="<?= base_url() ?>sobreNos">Sobre Nós</a></li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
        </aside>
    </div>

    <script>
        $(document).ready(function() {

            // abre a barra de configurações do aplicativo
            var settingSidebar = document.getElementById('settingSidebar');
            var settingSidebarLink = document.querySelector('a[href="settingSidebar"]');
            
            if (settingSidebarLink) {
                settingSidebarLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    settingSidebar.classList.toggle('showSettingPanel'); // Toggle a classe para mostrar/ocultar a barra lateral
                });
            }
        });
    </script>

    <section>
        <?= $this->renderSection('conteudo') ?>
    </section>

    
    <!-- General JS Scripts -->
    <script src="<?= base_url("assets/js/app.min.js") ?>"></script>
    
    <!-- JS Libraies -->
    <script src="<?= base_url("assets/bundles/apexcharts/apexcharts.min.js") ?>"></script>

    <!-- Template JS File -->
    <script src="<?= base_url("assets/js/scripts.js") ?>"></script>
    <!-- Custom JS File -->
    <script src="<?= base_url("assets/js/custom.js") ?>"></script>

    <!-- Datatables -->
    <script src="<?= base_url("assets/bundles/datatables/datatables.min.js") ?>"></script>
    <script src="<?= base_url("assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js") ?>"></script>
    <script src="<?= base_url("assets/bundles/jquery-ui/jquery-ui.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/page/datatables.js") ?>"></script>

    <!-- verifica a quantidade limite do estoque para alerta disparado por email -->
    <script>
        // Verificar a cada 24 horas (86400000 ms)
        // Verificar a cada 3 minutos (180000)
        // Verificar a cada 1 minuto (60000)
        // Verificar a cada 24 horas (86400000 ms)
        const intervalo = 86400000; // 1 minuto em milissegundos
        const ultimaVerificacao = localStorage.getItem('ultimaVerificacao');

        function verificarEstoque() {
            console.log("Verificação de estoque iniciada às " + new Date().toLocaleTimeString());

            fetch('<?= base_url() ?>FaleConosco/verificaEstoque')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta da rede.');
                    }
                    return response.text();
                })
                .then(data => {
                    console.log('Verificação de estoque realizada.');
                    // Processar a resposta se necessário
                    // console.log(data);
                    // Salvar a hora da última verificação no localStorage
                    localStorage.setItem('ultimaVerificacao', new Date().getTime());
                    // Atualizar o tempo para a próxima verificação
                    atualizarTempoParaProximaVerificacao();
                })
                .catch(error => console.error('Erro:', error));
        }

        function atualizarTempoParaProximaVerificacao() {
            const ultimaVerificacao = localStorage.getItem('ultimaVerificacao');
            const agora = new Date().getTime();

            if (ultimaVerificacao) {
                const tempoPassado = agora - ultimaVerificacao;
                const tempoRestante = Math.max(intervalo - tempoPassado, 0); // Garantir que tempoRestante não seja negativo

                if (tempoRestante > 0) {
                    console.log("Tempo restante para a próxima verificação: " + formatarTempo(tempoRestante));
                } else {
                    console.log("A próxima verificação será realizada em breve.");
                }
            }
        }

        function formatarTempo(millis) {
            const horas = Math.floor(millis / 3600000);
            const minutos = Math.floor((millis % 3600000) / 60000);
            const segundos = Math.floor((millis % 60000) / 1000);
            return `${horas}h ${minutos}m ${segundos}s`;
        }

        setInterval(verificarEstoque, intervalo);

        // Verificar imediatamente quando a página carregar, se tiver passado 1 minuto desde a última verificação
        document.addEventListener('DOMContentLoaded', function() {
            const agora = new Date().getTime();

            if (!ultimaVerificacao || (agora - ultimaVerificacao >= intervalo)) {
                verificarEstoque();
            } else {
                console.log("Ainda não passou 24 horas desde a última verificação.");
                atualizarTempoParaProximaVerificacao();
            }
        });

        function exibirModal(titleModal, menssageModal) {
            
            const ultimaVerificacao = localStorage.getItem('ultimaVerificacao');
            const agora = new Date().getTime();
            const tempoRestanteInicial = Math.max(intervalo - (agora - ultimaVerificacao), 0); // Garantir que tempoRestante não seja negativo

            const tituloModal = document.getElementsByClassName('modal-title')[0];
            tituloModal.innerHTML = titleModal;

            const mensagemModal = document.getElementById('mensagemModal');
            mensagemModal.innerHTML = menssageModal;

            $('#modalGlobal').modal('show');
        }

    </script>

    <style>
        footer {
            background-color: rgb(240, 243, 243);
            padding: 3%;
            text-align: center;
        }

    </style>
    
    <footer class="main-footer mt-4">
        <p>Departamento de Informática Rosário da Limeira - MG</p>
        <span>© 2024 Company, Inc</span>

        <?php 

            $redirectUrl = '';

            if (session()->get('usuarioNivel') == 1) {
                $redirectUrl = 'Home/homeAdmin';
            } elseif (session()->get('usuarioNivel') == 11) {
                $redirectUrl = 'Home/home';
            } 

        ?>
        <div class="container mt-2">
            <?php if (session()->get('usuarioId') != false) : ?>
                <a class="mt-2" href="<?= base_url($redirectUrl) ?>">Home</a>
            <?php endif; ?>
        </div>
    </footer>
</body>   
</html>