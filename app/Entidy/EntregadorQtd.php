<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class EntregadorQtd
{
    public $id;
    public $data_ini;
    public $vencimento;
    public $qtd;
    public $entregadores_id;
    public $receber_id;


    public function cadastar()
    {


        $obdataBase = new Database('entregador_qtd');

        $this->id = $obdataBase->insert([

            'qtd'                          => $this->qtd,
            'data_ini'                     => $this->data_ini,
            'vencimento'                   => $this->vencimento,
            'entregadores_id'              => $this->entregadores_id,
            'receber_id'                   => $this->receber_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('entregador_qtd'))->update('id = ' . $this->id, [

            'qtd'                          => $this->qtd,
            'data_ini'                     => $this->data_ini,
            'vencimento'                   => $this->vencimento,
            'entregadores_id'              => $this->entregadores_id,
            'receber_id'                   => $this->receber_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_qtd'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }


    public static function getListEntregadorQTD($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_qtd'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_qtd'))->select('COUNT(*) as qtd', 'entregador_qtd', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_qtd'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDReceber($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_qtd'))->select($fields, $table, 'receber_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_qtd'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_qtd'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getListView($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('view_entregador_qtd'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getIDListQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_qtd'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('entregador_qtd'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('entregador_qtd'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
