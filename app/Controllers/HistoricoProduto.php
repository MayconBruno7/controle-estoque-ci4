<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\HistoricoProdutoModel;

class HistoricoProduto extends BaseController
{
    protected $historicoProdutoModel;

    public function __construct()
    {
        $this->historicoProdutoModel = new HistoricoProdutoModel();

        // Só acessa se estiver logado
        if (!$this->getUsuario()) {
            return redirect()->to(base_url('home'));
        }
    }

    /**
     * getHistoricoProduto
     *
     * @param int|null $produtoId
     * @return void
     */
    public function getHistoricoProduto()
    {
        // Recuperando todos os segmentos da URL
        $segmentos  = $this->request->getURI()->getSegments(3);

        // Acessando o primeiro segmento
        $dataMod    = $segmentos[2] ?? null;

        if ($dataMod) {
            $dados = $this->historicoProdutoModel->getHistoricoProduto($dataMod);
            return $this->response->setJSON($dados);
        } else {
            return $this->response->setJSON(['error' => 'ID do produto não fornecido.']);
        }
    }
}
