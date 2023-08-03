<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class BoletoProducao

{

    public $id;
    public $data;
    public $codigo;
    public $destinatario;
    public $status;
    public $boletos_id;
    public $entregadores_id;
    public $ocorrencias_id;
    public $receber_id;

    public function cadastar()
    {


        $obdataBase = new Database('boleto_producao');

        $this->id = $obdataBase->insert([

            'data'                    => $this->data,
            'codigo'                  => $this->codigo,
            'destinatario'            => $this->destinatario,
            'status'                  => $this->status,
            'boletos_id'              => $this->boletos_id,
            'entregadores_id'         => $this->entregadores_id,
            'ocorrencias_id'          => $this->ocorrencias_id,
            'receber_id'              => $this->receber_id
        ]);

        return true;
    }


    public function atualizar()
    {
        return (new Database('boleto_producao'))->update('id = ' . $this->id, [

            'data'                    => $this->data,
            'codigo'                  => $this->codigo,
            'destinatario'            => $this->destinatario,
            'status'                  => $this->status,
            'boletos_id'              => $this->boletos_id,
            'entregadores_id'         => $this->entregadores_id,
            'ocorrencias_id'          => $this->ocorrencias_id,
            'receber_id'              => $this->receber_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('boleto_producao'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('boleto_producao'))->select('COUNT(*) as qtd', 'boleto_producao', null, null)
            ->fetchObject()
            ->qtd;
    }

    public static function getContarQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('boleto_producao'))->select('COUNT(*) as qtd', 'boleto_producao', $where, null)
            ->fetchObject()
            ->qtd;
    }

    public static function getQtdSequencia($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('boleto_producao'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('boleto_producao'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDReceberID($fields, $table, $where, $order, $limit)
    {
        return (new Database('boleto_producao'))->select($fields, $table, 'receber_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getBoletosID($fields, $table, $where, $order, $limit)
    {
        return (new Database('boleto_producao'))->select($fields, $table, 'boletos_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('boleto_producao'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }



    public function excluir()
    {
        return (new Database('boleto_producao'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('boleto_producao'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}