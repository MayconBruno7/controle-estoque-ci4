<?php

namespace App\Controllers;

use App\Models\FornecedorModel;
use App\Models\RelatorioModel;
use CodeIgniter\Controller;

class Relatorio extends BaseController
{
    protected $fornecedorModel;
    protected $model;

    public function __construct()
    {
        // Instancia o modelo de fornecedor
        $this->fornecedorModel  = new FornecedorModel();
        $this->model            = new RelatorioModel();

        // Só acessa se tiver logado
        if (!$this->getAdministrador()) {
            return redirect()->to('/home');
        }
    }

    public function index()
    {
        return view('restrita/formRelatorio');
    }

    public function relatorioMovimentacoes()
    {
        return view('restrita/formRelatorio', ['request' => $this->request]);
    }

    public function relatorioItensPorFornecedor()
    {
        $dados = $this->fornecedorModel->getLista('id');
        return view('restrita/formRelatorio', ['fornecedores' => $dados, 'request' => $this->request]);
    }

    public function getDados()
    {

        $segmentos      = $this->request->getURI()->getSegments(3);

        $tipo           = $segmentos[2]  ?? null;
        $dataInicio     = $segmentos[3]  ?? null;
        $dataFinal      = $segmentos[4]  ?? null;
        $id_fornecedor  = $segmentos[5]  ?? null;

        $dados = [];

        if (!empty($id_fornecedor) && $id_fornecedor !== 'null' && $id_fornecedor !== 'undefined') {
            switch ($tipo) {
                case 'dia':
                    $dados = $this->model->RelatorioDiaItemFornecedor($dataInicio, $id_fornecedor);
                    break;
                case 'semana':
                    $dados = $this->model->RelatorioSemanaItemFornecedor($dataInicio, $dataFinal, $id_fornecedor);
                    break;
                case 'mes':
                    $dados = $this->model->RelatorioMesItemFornecedor($dataInicio, $id_fornecedor);
                    break;
                case 'ano':
                    $dados = $this->model->RelatorioAnoItemFornecedor($dataInicio, $id_fornecedor);
                    break;
                default:
                    $dados = [];
            }
        } else {

            switch ($tipo) {
                case 'dia':
                    $dados = $this->model->RelatorioDia($dataInicio);
                    break;
                case 'semana':
                    $dados = $this->model->RelatorioSemana($dataInicio, $dataFinal);
                    break;
                case 'mes':
                    $dados = $this->model->RelatorioMes($dataInicio);
                    break;
                case 'ano':
                    $dados = $this->model->RelatorioAno($dataInicio);
                    break;
                default:
                    $dados = [];
            }
        }

        return $this->response->setContentType('application/json')->setBody(json_encode($this->formatarDadosParaGrafico($dados)));
    }

    private function formatarDadosParaGrafico($dados)
    {
        
        $id_movimentacao    = [];
        $entradas           = [];
        $saidas             = [];
        $labels             = [];
        $descricoes         = [];
        $valores            = [];

        foreach ($dados as $dado) {
            $labels[]           = formatarDataBrasileira($dado['data_pedido']);
            $descricoes[]       = $dado['descricao'];
            $valores[]          = number_format($dado['valor'], 2, ",", ".");
            $id_movimentacao[]  = $dado['id_movimentacoes'] ?? $dado['id'];
            
            if ($dado['tipo'] == 1) { // Entrada
                $entradas[] = $dado['quantidade'];
                $saidas[]   = 0;
            } else { // Saída
                $entradas[] = 0;
                $saidas[]   = $dado['quantidade'];
            }
        }

        return [
            'labels'            => $labels,
            'descricoes'        => $descricoes,
            'valores'           => $valores,
            'entradas'          => $entradas,
            'saidas'            => $saidas,
            'id_movimentacao'   => $id_movimentacao
        ];
    }
}
