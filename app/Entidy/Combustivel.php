<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Combustivel
{


    public $id;
    public $data;
    public $placa;
    public $valor;
    public $entregadores_id;
    public $veiculos_id;
    public $usuarios_id;

    public function cadastar()
    {


        $obdataBase = new Database('combustivel');

        $this->id = $obdataBase->insert([

            'data'               => $this->data,
            'placa'              => $this->placa,
            'valor'              => $this->valor,
            'veiculos_id'        => $this->veiculos_id,
            'entregadores_id'    => $this->entregadores_id,
            'usuarios_id'        => $this->usuarios_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('combustivel'))->update('id = ' . $this->id, [

            'data'               => $this->data,
            'placa'              => $this->placa,
            'valor'              => $this->valor,
            'veiculos_id'        => $this->veiculos_id,
            'entregadores_id'    => $this->entregadores_id,
            'usuarios_id'        => $this->usuarios_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('combustivel'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('combustivel'))->select('COUNT(*) as qtd', 'combustivel', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('combustivel'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('combustivel'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('combustivel'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}