<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Carteira
{


    public $id;
    public $nome;
    public $telefone;
    public $email;
    public $banco;
    public $agencia;
    public $conta;
    public $usuarios_id;
    public $rotas_id;
    public $regioes_id;
    public $veiculos_id;
    public $pix;
    public $cpf;
    public $cnh;
    public $renavam;
    public $apelido;
    public $tipo;
    public $forma_pagamento_id;
	
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
            'rotas_id'               => $this->rotas_id,
            'regioes_id'             => $this->regioes_id,
            'veiculos_id'            => $this->veiculos_id,
            'cnh'                    => $this->cnh,
            'renavam'                => $this->renavam,
            'cpf'                    => $this->cpf,
            'apelido'                => $this->apelido,
            'forma_pagamento_id'     => $this->forma_pagamento_id,
            'tipo'                   => $this->tipo,
            'pix'                    => $this->pix
        
        ]);

        return true;
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregadores'))->select($fields, $table, $where, $order, $limit)
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
            'rotas_id'               => $this->rotas_id,
            'regioes_id'             => $this->regioes_id,
            'veiculos_id'            => $this->veiculos_id,
            'cnh'                    => $this->cnh,
            'renavam'                => $this->renavam,
            'cpf'                    => $this->cpf,
            'apelido'                => $this->apelido,
            'forma_pagamento_id'     => $this->forma_pagamento_id,
            'tipo'                   => $this->tipo,
            'pix'                    => $this->pix
        
        ]);
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
