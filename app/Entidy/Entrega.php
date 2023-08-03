<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Entrega
{


    public $id;
    public $data;
    public $qtd;
    public $producao_id;
    public $entregadores_id;
    public $boletos_id;

    public function cadastar()
    {


        $obdataBase = new Database('entrega');

        $this->id = $obdataBase->insert([

            'data'                         => $this->data,
            'qtd'                          => $this->qtd,
            'producao_id'                  => $this->producao_id,
            'boletos_id'                   => $this->boletos_id,
            'entregadores_id'              => $this->entregadores_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('entrega'))->update('id = ' . $this->id, [

            'data'                         => $this->data,
            'qtd'                          => $this->qtd,
            'producao_id'                  => $this->producao_id,
            'boletos_id'                   => $this->boletos_id,
            'entregadores_id'              => $this->entregadores_id
        ]);
    }

    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entrega'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entrega'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getListID($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entrega'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entrega'))->select('COUNT(*) as qtd', 'entrega', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entrega'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getEntregaID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entrega'))->select($fields, $table, 'producao_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getEntregaBoletoID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entrega'))->select($fields, $table, 'boletos_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('entrega'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('entrega'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}