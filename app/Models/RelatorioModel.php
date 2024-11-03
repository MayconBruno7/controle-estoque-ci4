<?php


namespace App\Models;

use CodeIgniter\Model;

Class RelatorioModel extends CustomModel
{
    public $table = "movimentacao_item";

    // Movimentacoes
    public function RelatorioDia($dia = null)
    {
        if ($dia === null) {
            $dia = date('Y-m-d');
        }

        return $this->db->table('movimentacao m')
            ->select('mi.id_movimentacoes, m.data_pedido, p.descricao, mi.quantidade, mi.valor, m.tipo, SUM(mi.quantidade) OVER() AS quantidadeDia')
            ->join('movimentacao_item mi', 'm.id = mi.id_movimentacoes')
            ->join('produto p', 'mi.id_produtos = p.id')
            ->where('DATE(m.data_pedido)', $dia)
            ->orderBy('m.data_pedido', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function RelatorioSemana($dataInicio = null, $dataFinal = null)
    {
        if ($dataInicio === null || $dataFinal === null) {
            $hoje = new \DateTime();
            $inicioSemana = clone $hoje;
            $inicioSemana->modify('monday this week');
            $fimSemana = clone $hoje;
            $fimSemana->modify('sunday this week');
            $dataInicio = $inicioSemana->format('Y-m-d');
            $dataFinal = $fimSemana->format('Y-m-d');
        }
    
        return $this->db->table('movimentacao m')
            ->select('mi.id_movimentacoes, m.data_pedido, p.descricao, mi.quantidade, mi.valor, m.tipo, SUM(mi.quantidade) OVER() AS quantidadeSemana')
            ->join('movimentacao_item mi', 'm.id = mi.id_movimentacoes')
            ->join('produto p', 'mi.id_produtos = p.id')
            ->where('m.data_pedido >=', $dataInicio)
            ->where('m.data_pedido <=', $dataFinal)
            ->orderBy('m.data_pedido', 'ASC')
            ->get()
            ->getResultArray();
    }
    
    public function RelatorioMes($mes = null)
    {
        if ($mes === null) {
            $mes = date('Y-m');
        }

        return $this->db->table('movimentacao m')
            ->select('mi.id_movimentacoes, m.data_pedido, p.descricao, mi.quantidade, mi.valor, m.tipo, SUM(mi.quantidade) OVER() AS quantidadeMes')
            ->join('movimentacao_item mi', 'm.id = mi.id_movimentacoes')
            ->join('produto p', 'mi.id_produtos = p.id')
            ->where('DATE_FORMAT(m.data_pedido, "%Y-%m")', $mes)
            ->orderBy('m.data_pedido', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function RelatorioAno($ano = null)
    {
        // var_dump($ano);
        // exit;

        if ($ano === null) {
            $ano = date('Y');
        }

        return $this->db->table('movimentacao m')
            ->select('mi.id_movimentacoes, m.data_pedido, p.descricao, mi.quantidade, mi.valor, m.tipo, SUM(mi.quantidade) OVER() AS quantidadeAno')
            ->join('movimentacao_item mi', 'm.id = mi.id_movimentacoes')
            ->join('produto p', 'mi.id_produtos = p.id')
            ->where('DATE_FORMAT(m.data_pedido, "%Y")', $ano)
            ->orderBy('m.data_pedido', 'ASC')
            ->get()
            ->getResultArray();
    }


    // fornecedor
    public function RelatorioDiaItemFornecedor($dataInicio, $id_fornecedor)
    {
        return $this->db->table('movimentacao m')
            ->select('p.id AS id_produto, p.nome AS nome_produto, p.descricao, f.id AS id_fornecedor, f.nome AS nome_fornecedor, m.data_pedido, m.id, m.tipo, mi.quantidade, mi.valor')
            ->join('movimentacao_item mi', 'm.id = mi.id_movimentacoes')
            ->join('produto p', 'mi.id_produtos = p.id')
            ->join('fornecedor f', 'm.id_fornecedor = f.id')
            ->where('DATE(m.data_pedido)', $dataInicio)
            ->where('m.id_fornecedor', $id_fornecedor)
            ->orderBy('m.data_pedido', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function RelatorioSemanaItemFornecedor($dataInicio, $dataFinal, $id_fornecedor)
    {
        return $this->db->table('movimentacao m')
            ->select('mi.id_movimentacoes, m.data_pedido, p.descricao, mi.quantidade, mi.valor, m.tipo')
            ->join('movimentacao_item mi', 'm.id = mi.id_movimentacoes')
            ->join('produto p', 'mi.id_produtos = p.id')
            ->where('m.data_pedido >=', $dataInicio)
            ->where('m.data_pedido <=', $dataFinal)
            ->where('m.id_fornecedor', $id_fornecedor)
            ->orderBy('m.data_pedido', 'ASC')
            ->get()
            ->getResultArray();
    }
    
    public function RelatorioMesItemFornecedor($dataInicio, $id_fornecedor)
    {
        return $this->db->table('movimentacao m')
            ->select('mi.id_movimentacoes, m.data_pedido, p.descricao, mi.quantidade, mi.valor, m.tipo')
            ->join('movimentacao_item mi', 'm.id = mi.id_movimentacoes')
            ->join('produto p', 'mi.id_produtos = p.id')
            ->where('DATE_FORMAT(m.data_pedido, "%Y-%m")', $dataInicio)
            ->where('m.id_fornecedor', $id_fornecedor)
            ->orderBy('m.data_pedido', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function RelatorioAnoItemFornecedor($ano, $id_fornecedor)
    {
        return $this->db->table('movimentacao m')
            ->select('mi.id_movimentacoes, m.data_pedido, p.descricao, mi.quantidade, mi.valor, m.tipo')
            ->join('movimentacao_item mi', 'm.id = mi.id_movimentacoes')
            ->join('produto p', 'mi.id_produtos = p.id')
            ->join('fornecedor f', 'm.id_fornecedor = f.id')
            ->where('DATE_FORMAT(m.data_pedido, "%Y")', $ano)
            ->where('m.id_fornecedor', $id_fornecedor)
            ->orderBy('m.data_pedido', 'ASC')
            ->get()
            ->getResultArray();
    }
    
}

