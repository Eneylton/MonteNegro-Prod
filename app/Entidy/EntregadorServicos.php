<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class EntregadorServicos
{


    public $id;
    public $entregadores_id;
    public $servicos_id;

    public function cadastar()
    {


        $obdataBase = new Database('entregador_servicos');

        $this->id = $obdataBase->insert([

            'entregadores_id'         => $this->entregadores_id,
            'servicos_id'              => $this->servicos_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('entregador_servicos'))->update('id = ' . $this->id, [

            'entregadores_id'         => $this->entregadores_id,
            'servicos_id'              => $this->servicos_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_servicos'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_servicos'))->select('COUNT(*) as qtd', 'entregador_servicos', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_servicos'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getEntregadorID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_servicos'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
        ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    public static function getEntreID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_servicos'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
        ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('entregador_servicos'))->delete('id = ' . $this->id);
    }

    public static function getIDListEntregador($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_setores'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
        ->fetchAll(PDO::FETCH_CLASS, self::class);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('entregador_servicos'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
