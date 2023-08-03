<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Lote
{

    public $id;
    public $data;
    public $numero;
    public $qtd;
    public $setores_id;
    public $servicos_id;
    public $clientes_id;
    public $usuarios_id;


    public function cadastar()
    {


        $obdataBase = new Database('lote');

        $this->id = $obdataBase->insert([

            'data'                    => $this->data,
            'numero'                  => $this->numero,
            'qtd'                     => $this->qtd,
            'setores_id'              => $this->setores_id,
            'servicos_id'             => $this->servicos_id,
            'clientes_id'             => $this->clientes_id,
            'usuarios_id'             => $this->usuarios_id

        ]);

        return true;
    }


    public function atualizar()
    {
        return (new Database('lote'))->update('id = ' . $this->id, [

            'data'                    => $this->data,
            'numero'                  => $this->numero,
            'qtd'                     => $this->qtd,
            'setores_id'              => $this->setores_id,
            'servicos_id'             => $this->servicos_id,
            'clientes_id'             => $this->clientes_id,
            'usuarios_id'             => $this->usuarios_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('lote'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('lote'))->select('COUNT(*) as qtd', 'lote', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('lote'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('lote'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }



    public function excluir()
    {
        return (new Database('lote'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('lote'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}