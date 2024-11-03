<?php

    /**
     * exibeTitulo
     *
     * @param string $titulo 
     * @param array $parametro 
     * @return string
     */
    function exibeTitulo($titulo, $parametro = ['acao' => 'lista'])
{
    if (!isset($parametro['controller'])) {
        $parametro['controller'] = $titulo;
    }

    $subTitulo = $titulo;
    $link = '/lista';
    $icone = 'list';

    switch ($parametro['acao']) {
        case 'new':
            $subTitulo .= ' - Novo';
            break;
        case 'update':
            $subTitulo .= ' - Alteração';
            break;
        case 'delete':
            $subTitulo .= ' - Exclusão';
            break;
        case 'view':
            $subTitulo .= ' - Visualização';
            break;
        case 'lista':
            $link = '/form/new/0';
            $icone = 'plus';
            break;
    }

    // var_dump($parametro['acao']);
    // exit;

    ob_start(); // Inicia o buffer de saída
    ?>
    <section>
        <div class="blog-banner">
            <div class="row">
                <?php if (isset($parametro['acao']) && $parametro['acao'] != 'lista') : ?>
                    <div class="col-10 text-left">
                        <h1 style="color: #384aeb;"><?php echo $subTitulo; ?></h1>
                    </div>
                <?php endif; ?>
                <div class="col-2 mb-5 text-right" <?= isset($parametro['acao']) && $parametro['acao'] == 'lista' ? 'style="margin-left: 85%; margin-top: 8%;"' : '' ?>>
                    <?php if ($parametro['acao'] != 'view') : ?>
                    <a href="<?php echo base_url() . $parametro['controller'] . $link; ?>" class="btn btn-secondary btn-sm btn-icons-crud" title="<?= $parametro['acao'] == 'lista' ? 'Novo' : 'Voltar' ?>">
                        <i class="fa fa-<?php echo $icone; ?>" aria-hidden="true"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php

    $texto = ob_get_clean(); // Captura o buffer e limpa

    $texto .= mensagemSucesso();
    $texto .= mensagemError();

    return $texto;
}


    /**
     * mensagemSucesso
     *
     * @return string
     */
    function mensagemSucesso()
    {
        $msgSucess = session()->getFlashData('msgSuccess');
        $texto = '';

        if (isset($msgSucess)) {

            $texto .= '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>' . $msgSucess. '</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

        }

        return $texto;
    }

    /**
     * mensagemError
     *
     * @return string
     */
    function mensagemError()
    {
        $msgError   = session()->getFlashData('msgError');
        $texto      = '';

        if (isset($msgError)) {

            $texto .= '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>' . $msgError. '</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

        }

        return $texto;
    }

    /**
     * setaMsgErrorCampo
     *
     * @param string $chave 
     * @param array $errors 
     * @return string
     */
    function setaMsgErrorCampo($chave, $errors)
    {
        $texto = '';

        if (!empty($errors[$chave])) {
            $texto = '<div class="text-danger mt-2">' . $errors[$chave] . '</div>';
        }

        return $texto;
    }


    /**
     * mostraStatus
     *
     * @param int $status 
     * @return string
     */
    function mostraStatus($status = 0)
    {
        if ($status == 0) {
            
        } else if ($status == 1) {
            return "Ativo";
        } else if ($status == 2) {
            return "Inativo";            
        }
    }

    /**
     * comboboxStatus
     *
     * @param int $status 
     * @return string
     */
    function comboboxStatus($status = 0)
    {
        return '<label for="statusRegistro" class="form-label">Status</label>
                <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                    <option value=""  ' . (isset($status) ? ($status == 0 ? "selected" : "") : "") . '>...</option>
                    <option value="1" ' . (isset($status) ? ($status == 1 ? "selected" : "") : "") . '>Ativo</option>
                    <option value="2" ' . (isset($status) ? ($status == 2 ? "selected" : "") : "") . '>Inativo</option>
                </select>';
    }

    /**
     * setaValor
     *
     * @param string $campo 
     * @param string $dados 
     * @param mixed $valorDefault 
     * @return mixed
     */
    function setValor($campo, $dados = [], $valorDefault = "")
    {
        if (!empty(set_value($campo))) {
            return set_value($campo);
        } else {
            if (isset($dados[$campo])) {
                return $dados[$campo];
            } else {
                return $valorDefault;
            }
        }
    }

    function getCondicao($status)
    {
        if ($status == 1) {
            return "Novo";
        } elseif ($status == 2) {
            return "Usado";
        } else {
            return "...";
        }
    }

    function getStatusDescricao($status)
    {
        if ($status == 1) {
            return "Ativo";
        } elseif ($status == 2) {
            return "Inativo";
        } else {
            return "...";
        }
    }

    function getNivelDescricao($nivel)
    {
        if ($nivel == 1) {
            return "Administrador";
        } elseif ($nivel == 2) {
            return "Usuário";
        } else {
            return "...";
        }
    }

    function getTipoMovimentacao($tipo)
    {
        if ($tipo == 1) {
            return "Entrada";
        } elseif ($tipo == 2) {
            return "Saída";
        } else {
            return "...";
        }
    }

    function getTipo($tipo)
    {
        if ($tipo == 1) {
            return "Entrada";
        } elseif ($tipo == 2) {
            return "Saida";
        } else {
            return "...";
        }
    }

    function formatarCNPJInput($cnpj) {
        // Remove caracteres especiais
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    
        // Adiciona pontos e traço
        $cnpjFormatado = substr($cnpj, 0, 2) . '.';
        $cnpjFormatado .= substr($cnpj, 2, 3) . '.';
        $cnpjFormatado .= substr($cnpj, 5, 3) . '/';
        $cnpjFormatado .= substr($cnpj, 8, 4) . '-';
        $cnpjFormatado .= substr($cnpj, 12, 2);
    
        return $cnpjFormatado;
    }    

    function formatarCPF($cpf) {
        // Remove caracteres indesejados do CPF
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
        // Adiciona pontos e traço ao CPF
        if(strlen($cpf) == 11) {
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9);
        }
    
        return $cpf; // Retorna o CPF não formatado se não tiver 11 dígitos
    }

    function formatarTelefone($telefone) {
        // Remove todos os caracteres não numéricos
        $telefone = preg_replace('/\D/', '', $telefone);
    
        // Verifica se o telefone possui 11 dígitos (incluindo o DDD) e formata de acordo
        if (strlen($telefone) == 11) {
            $telefoneFormatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
        } else {
            // Se não tiver 11 dígitos, trata como um telefone comum (DDD sem o 9)
            $telefoneFormatado = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
        }
    
        return $telefoneFormatado;
    }

    function formatarDataBrasileira($data) {
        // Converte a data para o formato timestamp
        $timestamp = strtotime($data);
    
        // Verifica se a string contém um horário
        $temHorario = (strpos($data, ':') !== false);
    
        // Formata a data no padrão brasileiro
        $formato = $temHorario ? 'd/m/Y H:i:s' : 'd/m/Y';
        $dataFormatada = date($formato, $timestamp);
        
        return $dataFormatada;
    }

    function formatarSalario($salario, $moeda = 'R$', $decimais = 2) {
        // Substituir vírgulas por ponto para padronizar o separador decimal
        $salario = str_replace(',', '.', $salario);
    
        // Remover caracteres não numéricos exceto ponto
        $salario = preg_replace("/[^0-9.]/", "", $salario);
    
        // Converter para número de ponto flutuante
        $salario = (float)$salario;
    
        // Formatar o número com vírgula como separador de milhar e precisão de casas decimais
        $salario_formatado = number_format($salario, $decimais, ',', '.');
    
        // Retornar o salário formatado com o símbolo da moeda
        return $moeda . ' ' . $salario_formatado;
    }

    function retornaHomeAdminOuHome() {
        if (session()->get('usuarioNivel') == 1) {
            $redirectUrl = 'Home/homeAdmin';
        } elseif (session()->get('usuarioNivel') == 11) {
            $redirectUrl = 'Home/home';
        } 

        return $redirectUrl;
    }


    /**
     * getDataTables
     *
     * @param string $table_id 
     * @return string
     */
    function getDataTables($table_id)
    {
        return '
     
            <script type="text/javascript" src="' . base_url() . 'assets/DataTables/datatables.min.js"></script>         
            <style>
                .dataTables_wrapper {
                    position: relative;
                    clear: both;
                }
                
                .dataTables_filter {
                    float: right;
                    margin-bottom: 5px;
                }
                
                .dataTables_paginate {
                    float: right;
                    margin: 0;
                }
                
                .dataTables_paginate .pagination {
                    margin: 0;
                    padding: 0;
                    list-style: none;
                    white-space: nowrap; /* Evita que a paginação quebre em várias linhas */
                }
                
                .dataTables_paginate .pagination .page-link {
                    border: none;
                    outline: none;
                    box-shadow: none;
                    margin: 0 2px; /* Espaçamento entre os botões de paginação */
                }
                
                .dataTables_paginate .pagination .page-item.disabled .page-link {
                    pointer-events: none;
                    color: #aaa;
                }
                
                .dataTables_paginate .pagination .page-item.active .page-link {
                    background-color: #007bff;
                    color: #fff;
                }
                
                .dataTables_paginate .pagination .page-link:hover {
                    background-color: #0056b3;
                    color: #fff;
                }
            </style>
    
            <script>
                $(document).ready( function() {
                    $("#' . $table_id . '").DataTable( {
                        "order": [],
                        "columnDefs": [{
                            "targets": "no-sort",
                            "orderable": false,                       
                        }],
                        language: {
                            "sEmptyTable":      "Nenhum registro encontrado",
                            "sInfo":            "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                            "sInfoEmpty":       "Mostrando 0 até 0 de 0 registros",
                            "sInfoFiltered":    "(Filtrados de _MAX_ registros)",
                            "sInfoPostFix":     "",
                            "sInfoThousands":   ".",
                            "sLengthMenu":      "_MENU_ resultados por página",
                            "sLoadingRecords":  "Carregando...",
                            "sProcessing":      "Processando...",
                            "sZeroRecords":     "Nenhum registro encontrado",
                            "sSearch":          "Pesquisar",
                            "oPaginate": {
                                "sNext":        "Próximo",
                                "sPrevious":    "Anterior",
                                "sFirst":       "Primeiro",
                                "sLast":        "Último"
                            },
                            "oAria": {
                                "sSortAscending":   ": Ordenar colunas de forma ascendente",
                                "sSortDescending":  ": Ordenar colunas de forma descendente"
                            }
                        }
                    });
                });
            </script>
        ';
    }