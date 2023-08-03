<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class EntregadorSetor
{


    public $id;
    public $entregadores_id;
    public $setores_id;
    public $valor;

    public function cadastar()
    {


        $obdataBase = new Database('entregador_setores');

        $this->id = $obdataBase->insert([

            'entregadores_id'         => $this->entregadores_id,
            'setores_id'              => $this->setores_id,
            'valor'                   => $this->valor

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('entregador_setores'))->update('id = ' . $this->id, [
            'entregadores_id'         => $this->entregadores_id,
            'setores_id'              => $this->setores_id,
            'valor'                   => $this->valor
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_setores'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_setores'))->select('COUNT(*) as qtd', 'entregador_setores', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_setores'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getsetorID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_setores'))->select($fields, $table, 'setores_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getEntreID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_setores'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
        ->fetchAll(PDO::FETCH_CLASS, self::class);
    }


    public static function getIDEntregador($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_setores'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDListEntregador($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_setores'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
        ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function excluir()
    {
        return (new Database('entregador_setores'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('entregador_setores'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
