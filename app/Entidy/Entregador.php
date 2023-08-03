<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Entregador
{


    public $id;
    public $nome;
    public $telefone;
    public $email;
    public $banco;
    public $agencia;
    public $conta;
    public $usuarios_id;
    public $veiculos_id;
    public $pix;
    public $cpf;
    public $cnh;
    public $renavam;
    public $apelido;
    public $tipo;
    public $forma_pagamento_id;
    public $admissao;
    public $recisao;
    public $status;
    public $valor_boleto;
    public $valor_cartao;
    public $valor_grande;
    public $valor_pequeno;
    public $regioes_id;
	
    public function cadastar()
    {


        $obdataBase = new Database('entregadores');

        $this->id = $obdataBase->insert([

            'nome'                   => $this->nome,
            'telefone'               => $this->telefone,
            'email'                  => $this->email,
            'banco'                  => $this->banco,
            'agencia'                => $this->agencia,
            'conta'                  => $this->conta,
            'usuarios_id'            => $this->usuarios_id,
            'veiculos_id'            => $this->veiculos_id,
            'cnh'                    => $this->cnh,
            'renavam'                => $this->renavam,
            'regioes_id'             => $this->regioes_id,
            'cpf'                    => $this->cpf,
            'apelido'                => $this->apelido,
            'forma_pagamento_id'     => $this->forma_pagamento_id,
            'tipo'                   => $this->tipo,
            'admissao'               => $this->admissao,
            'recisao'                => $this->recisao,
            'status'                 => $this->status,
            'valor_boleto'           => $this->valor_boleto,
            'valor_cartao'           => $this->valor_cartao,
            'valor_grande'           => $this->valor_grande,
            'valor_pequeno'          => $this->valor_pequeno,
            'pix'                    => $this->pix
        
        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('entregadores'))->update('id = ' . $this->id, [
            
         
            'nome'                   => $this->nome,
            'telefone'               => $this->telefone,
            'email'                  => $this->email,
            'banco'                  => $this->banco,
            'agencia'                => $this->agencia,
            'conta'                  => $this->conta,
            'usuarios_id'            => $this->usuarios_id,
            'veiculos_id'            => $this->veiculos_id,
            'cnh'                    => $this->cnh,
            'renavam'                => $this->renavam,
            'cpf'                    => $this->cpf,
            'apelido'                => $this->apelido,
            'regioes_id'             => $this->regioes_id,
            'forma_pagamento_id'     => $this->forma_pagamento_id,
            'tipo'                   => $this->tipo,
            'admissao'               => $this->admissao,
            'recisao'                => $this->recisao,
            'status'                 => $this->status,
            'valor_boleto'           => $this->valor_boleto,
            'valor_cartao'           => $this->valor_cartao,
            'valor_grande'           => $this->valor_grande,
            'valor_pequeno'          => $this->valor_pequeno,
            'pix'                    => $this->pix
        
        ]);
    }

    public static function getList($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('entregadores'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregadores'))->select('COUNT(*) as qtd', 'entregadores', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregadores'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public function excluir()
    {
        return (new Database('entregadores'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('entregadores'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
