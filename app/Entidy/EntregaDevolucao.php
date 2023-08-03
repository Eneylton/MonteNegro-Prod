<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class EntregaDevolucao
{

    public $id;
    public $data;
    public $entrega;
    public $devolucao;
    public $entregadores_id;
    public $receber_id;
    public $producao_id;
    public $boletos_id;


    public function cadastar()
    {


        $obdataBase = new Database('entrega_devolucao');

        $this->id = $obdataBase->insert([

            'data'                          => $this->data,
            'entrega'                       => $this->entrega,
            'devolucao'                     => $this->devolucao,
            'entregadores_id'               => $this->entregadores_id,
            'receber_id'                    => $this->receber_id,
            'boletos_id'                    => $this->boletos_id,
            'producao_id'                   => $this->producao_id
        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('entrega_devolucao'))->update('id = ' . $this->id, [

            'data'                          => $this->data,
            'entrega'                       => $this->entrega,
            'devolucao'                     => $this->devolucao,
            'entregadores_id'               => $this->entregadores_id,
            'receber_id'                    => $this->receber_id,
            'boletos_id'                    => $this->boletos_id,
            'producao_id'                   => $this->producao_id
        ]);
    }

    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entrega_devolucao'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entrega_devolucao'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getListID($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entrega_devolucao'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entrega_devolucao'))->select('COUNT(*) as qtd', 'entrega', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entrega_devolucao'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getEntregaID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entrega_devolucao'))->select($fields, $table, 'producao_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getDevolucaoID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entrega_devolucao'))->select($fields, $table, 'producao_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getReceberID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entrega_devolucao'))->select($fields, $table, 'receber_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getBoletosID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entrega_devolucao'))->select($fields, $table, 'boletos_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('entrega_devolucao'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('entrega_devolucao'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}