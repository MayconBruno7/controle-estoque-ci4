<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class FornecedorModel extends CustomModel
{
    protected $table        = 'fornecedor';
    protected $primaryKey   = 'id';
    
    protected $allowedFields = ['cnpj', 'nome', 'telefone', 'statusRegistro', 'estado', 'cidade', 'bairro', 'endereco', 'numero', 'telefone']; 
    
    protected $validationRules = [
        'nome' => [
            'label' => 'Nome',
            'rules' => 'required|min_length[3]|max_length[144]'
        ],
        'cnpj' => [
            'label' => 'CNPJ',
            'rules' => 'required|valida_CNPJ',
            'errors' => [
                'valida_CNPJ' => 'O CNPJ fornecido é inválido.'
            ]
        ],
        'telefone' => [
            'label' => 'Telefone',
            'rules' => 'required|min_length[9]|max_length[14]'
        ],
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|integer'
        ]
    ];

    /**
     * getLista function
     *
     * @param string $orderBy
     * @return void
     */
    public function getLista($orderBy = 'id')
    {
        $session = Services::session();

        if ($session->get('usuarioNivel') == 1) {
            return $this->orderBy($orderBy, 'DESC')->findAll(); 
        } else {
            return $this->where('statusRegistro', 1) 
                        ->orderBy($orderBy, 'DESC')
                        ->findAll();
        }
    }

    /**
     * requireAPI function
     *
     * @param string $cnpj
     * @return void
     */
    public function requireAPI($cnpj)
    {
        $cnpj_limpo = preg_replace("/[^0-9]/", "", $cnpj);
        $url = "https://www.receitaws.com.br/v1/cnpj/{$cnpj_limpo}";

        $options = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];

        $context    = stream_context_create($options);
        $response   = @file_get_contents($url, false, $context);

        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data !== null && isset($data['status']) && $data['status'] == 'OK') {
                return $data; 
            } else {
                return ['error' => 'Erro ao consultar a API: ' . (isset($data['message']) ? $data['message'] : 'Resposta inválida')];
            }
        } else {
            return ['error' => 'Erro ao consultar a API.'];
        }
    }

    /**
     * getCidadeCombobox
     *
     * @param int $estado 
     * @return array
     */
    public function getCidadeCombobox($estado) 
    {
        return $this->db->table('cidade as c')
                        ->join('estado as e', 'c.estado = e.id')
                        ->where('c.estado', $estado)
                        ->select('c.id, c.nome')
                        ->orderBy('c.nome')
                        ->get()->getResultArray();
    }
}
